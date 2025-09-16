<?php

namespace Modules\Shop\app\Http\Controllers;

use App\Enums\RedirectType;
use App\Http\Controllers\Controller;
use App\Traits\RedirectHelperTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Language\app\Enums\TranslationModels;
use Modules\Language\app\Models\Language;
use Modules\Language\app\Traits\GenerateTranslationTrait;
use Modules\Shop\app\Http\Requests\ProductRequest;
use Modules\Shop\app\Models\FileUpload;
use Modules\Shop\app\Models\Product;
use Modules\Shop\app\Models\ProductCategory;

class ProductController extends Controller {
    use GenerateTranslationTrait, RedirectHelperTrait;
    public function index(Request $request) {
        checkAdminHasPermissionAndThrowException('product.management');
        $query = Product::query();

        $query->when($request->filled('keyword'), function ($qa) use ($request) {
            $qa->whereHas('translations', function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->keyword . '%');
                $q->orWhere('description', 'like', '%' . $request->keyword . '%');
            });
        });

        $query->when($request->filled('is_popular'), function ($q) use ($request) {
            $q->where('is_popular', $request->is_popular);
        });

        $query->when($request->filled('status'), function ($q) use ($request) {
            $q->where('status', $request->status);
        });

        $orderBy = $request->filled('order_by') && $request->order_by == 1 ? 'asc' : 'desc';

        if ($request->filled('par-page')) {
            $products = $request->get('par-page') == 'all' ? $query->with('translation', 'category.translation')->orderBy('id', $orderBy)->get() : $query->with('translation', 'category.translation')->orderBy('id', $orderBy)->paginate($request->get('par-page'))->withQueryString();
        } else {
            $products = $query->with('translation', 'category.translation')->orderBy('id', $orderBy)->paginate(10)->withQueryString();
        }

        $un_used_files = FileUpload::count();

        return view('shop::Product.index', compact('products','un_used_files'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        checkAdminHasPermissionAndThrowException('product.management');
        $categories = ProductCategory::with('translation')->active()->get();
        $type = request('type', Product::PHYSICAL_TYPE);
        $is_digital = $type == Product::DIGITAL_TYPE;

        return view('shop::Product.create', ['categories' => $categories, 'type' => $type, 'is_digital' => $is_digital]);
    }

    public function store(ProductRequest $request): RedirectResponse {
        checkAdminHasPermissionAndThrowException('product.management');
        $product = Product::create(array_merge(['admin_id' => Auth::guard('admin')->user()->id], $request->validated()));

        if ($product && $request->hasFile('image')) {
            $file_name = file_upload($request->image, 'uploads/custom-images/', $product->image);
            $product->image = $file_name;
            $product->save();
        }
        if (!empty($product->file_path)) {
            FileUpload::where('path', $product->file_path)->first()->delete();
        }

        $this->generateTranslations(
            TranslationModels::Product,
            $product,
            'product_id',
            $request,
        );

        return $this->redirectWithMessage(
            RedirectType::CREATE->value,
            'admin.product.edit',
            [
                'product' => $product->id,
                'code'    => allLanguages()->first()->code,
            ]
        );
    }

    public function edit($id) {
        checkAdminHasPermissionAndThrowException('product.management');
        $code = request('code') ?? getSessionLanguage();
        if (!Language::where('code', $code)->exists()) {
            abort(404);
        }
        $product = Product::findOrFail($id);
        $categories = ProductCategory::with('translation')->get();
        $languages = allLanguages();

        $is_digital = $product->type == Product::DIGITAL_TYPE;

        return view('shop::Product.edit', compact('product', 'code', 'categories', 'languages', 'is_digital'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, $id) {
        checkAdminHasPermissionAndThrowException('product.management');
        $validatedData = $request->validated();

        $product = Product::findOrFail($id);

        if ($product && !empty($request->image)) {
            $file_name = file_upload($request->image, 'uploads/custom-images/', $product->image);
            $product->image = $file_name;
            $product->save();
        }
        if (!empty($request->file_path) && $product->file_path != $request->file_path) {
            $path = "app/{$product->file_path}";
            if (File::exists(storage_path($path))) {
                File::delete(storage_path($path));
            }
            FileUpload::where('path', $request->file_path)->first()->delete();
        }
        $product->update($request->except('image'));

        $this->updateTranslations(
            $product,
            $request,
            $validatedData,
        );

        return $this->redirectWithMessage(
            RedirectType::UPDATE->value,
            'admin.product.edit',
            ['product' => $product->id, 'code' => $request->code]
        );
    }

    public function destroy($id) {
        checkAdminHasPermissionAndThrowException('product.management');

        $product = Product::findOrFail($id);

        if ($product->type == Product::DIGITAL_TYPE && $product->order_products()->count() > 0) {
            return redirect()->back()->with(['alert-type' => 'error', 'message' => __('Cannot delete product, it has associated orders.')]);
        }
        $product->delete();

        return $this->redirectWithMessage(RedirectType::DELETE->value, 'admin.product.index');
    }

    public function statusUpdate($id) {
        checkAdminHasPermissionAndThrowException('product.management');

        $product = Product::find($id);
        $status = $product->status == 1 ? 0 : 1;
        $product->update(['status' => $status]);

        $notification = __('Updated Successfully');

        return response()->json([
            'success' => true,
            'message' => $notification,
        ]);
    }
    public function upload(Request $request) {
        checkAdminHasPermissionAndThrowException('product.management');
        $file = $request->file('file');

        if (!$file || !$file->isValid()) {
            return response()->json(['success' => false, 'message' => __('No valid file found')], 400);
        }

        $extension = strtolower($file->getClientOriginalExtension());

        if ($extension !== 'zip') {
            return response()->json(['success' => false, 'message' => __('Only ZIP files are allowed')], 422);
        }

        $sanitizedName = preg_replace('/[^A-Za-z0-9.\-_]/', '_', pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $fileName = $sanitizedName . '_' . Str::random(10) . '.zip';

        // Security: prevent Blade/JS injections or unsafe patterns
        if (preg_match('/\{\{.*\}\}|{!!.*!!}|<\?php|<script|<\/script>/', $fileName)) {
            return response()->json(['success' => false, 'message' => __('Unsafe filename')], 400);
        }

        // Store chunks temporarily
        $uuid = $request->get('dzuuid');
        $chunkIndex = $request->get('dzchunkindex');
        $totalChunks = (int) $request->get('dztotalchunkcount');

        $tempDir = "chunks/{$uuid}";
        $chunkPath = "{$tempDir}/{$chunkIndex}";

        Storage::disk('local')->put($chunkPath, file_get_contents($file->getRealPath()));

        // When all chunks are uploaded
        if (count(Storage::disk('local')->files($tempDir)) === $totalChunks) {
            $finalDir = "public/products";
            $finalPath = "{$finalDir}/{$fileName}";

            Storage::makeDirectory($finalDir);
            $outputPath = storage_path("app/{$finalPath}");

            $handle = fopen($outputPath, 'ab');
            if (!$handle) {
                return response()->json(['success' => false, 'message' => __('Failed to open final file')], 500);
            }

            for ($i = 0; $i < $totalChunks; $i++) {
                $chunkFilePath = storage_path("app/{$tempDir}/{$i}");
                if (!file_exists($chunkFilePath)) {
                    fclose($handle);
                    return response()->json(['success' => false, 'message' => __('Missing chunk ') . $i], 500);
                }
                fwrite($handle, file_get_contents($chunkFilePath));
            }

            fclose($handle);
            Storage::deleteDirectory($tempDir);

            FileUpload::create([
                'extension' => $extension,
                'size'      => $request->dztotalfilesize,
                'path'      => $finalPath,
                'expiry_at' => Carbon::now()->addHours(24),
            ]);

            return response()->json([
                'success'  => true,
                'message'  => __('Upload complete'),
                'filename' => $finalPath,
            ]);
        }

        return response()->json(['success' => true, 'message' => __('Chunk uploaded successfully')]);
    }
    public function deleteUploadFile($file_name) {
        checkAdminHasPermissionAndThrowException('product.management');

        $path = "public/products/{$file_name}";

        $uploadFile = FileUpload::where('path', $path)->first();

        $path = "app/{$path}";
        if ($uploadFile) {
            if (File::exists(storage_path($path))) {
                File::delete(storage_path($path));
            }
            $uploadFile->delete();
            return response()->json(['success' => true, 'message' => __('Deleted Successfully')]);
        }
        return response()->json(['success' => false, 'message' => __('Not Found!')]);
    }
    public function download($slug) {
        checkAdminHasPermissionAndThrowException('product.management');
        try {
            $product = Product::whereSlug($slug)->firstOrFail();
            $response = $product->download();
            if (isset($response->type) && $response->type == "error") {
                throw new Exception($response->message);
            }
            return $response;
        } catch (Exception $e) {
            info($e->getMessage());
            return back();
        }
    }
    public function deleteAllUnusedFiles() {
        checkAdminHasPermissionAndThrowException('product.management');

        $files = FileUpload::get();

        foreach ($files as $file) {
            $path = "app/{$file->path}";
            if (File::exists(storage_path($path))) {
                File::delete(storage_path($path));
            }
            $file->delete();
        }

        return $this->redirectWithMessage(RedirectType::DELETE->value);
    }
}
