<?php

namespace Modules\Shop\app\Http\Controllers;

use App\Enums\RedirectType;
use App\Http\Controllers\Controller;
use App\Traits\RedirectHelperTrait;
use Illuminate\Http\RedirectResponse;
use Modules\Language\app\Enums\TranslationModels;
use Modules\Language\app\Models\Language;
use Modules\Language\app\Traits\GenerateTranslationTrait;
use Modules\Shop\app\Http\Requests\ProductCategoryRequest;
use Modules\Shop\app\Models\ProductCategory;

class ProductCategoryController extends Controller {
    use GenerateTranslationTrait, RedirectHelperTrait;

    public function index() {
        checkAdminHasPermissionAndThrowException('product.category.management');
        $categories = ProductCategory::with('translation')->paginate(15);
        return view('shop::Category.index', ['categories' => $categories]);
    }

    public function create() {
        checkAdminHasPermissionAndThrowException('product.category.management');
        return view('shop::Category.create');
    }

    public function store(ProductCategoryRequest $request): RedirectResponse {
        checkAdminHasPermissionAndThrowException('product.category.management');
        $category = ProductCategory::create($request->validated());
        $languages = Language::all();
        $this->generateTranslations(
            TranslationModels::ProductCategory,
            $category,
            'product_category_id',
            $request,
        );

        return $this->redirectWithMessage(RedirectType::CREATE->value, 'admin.product.category.edit', ['category' => $category->id, 'code' => $languages->first()->code]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id) {
        checkAdminHasPermissionAndThrowException('product.category.management');
        $code = request('code') ?? getSessionLanguage();
        if (!Language::where('code', $code)->exists()) {
            abort(404);
        }
        $category = ProductCategory::findOrFail($id);
        $languages = allLanguages();

        return view('shop::Category.edit', compact('category', 'code', 'languages'));
    }

    public function update(ProductCategoryRequest $request, $id) {
        checkAdminHasPermissionAndThrowException('product.category.management');
        $validatedData = $request->validated();
        $product_category = ProductCategory::findOrFail($id);

        $product_category->update($validatedData);

        $this->updateTranslations(
            $product_category,
            $request,
            $validatedData,
        );

        return $this->redirectWithMessage(RedirectType::UPDATE->value, 'admin.product.category.edit', ['category' => $product_category->id, 'code' => $request->code]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        checkAdminHasPermissionAndThrowException('product.category.management');
        $product_category = ProductCategory::findOrFail($id);
        if ($product_category->products()->count() > 0) {
            return $this->redirectWithMessage(RedirectType::ERROR->value);
        }
        $product_category->translations()->each(function ($translation) {
            $translation->category()->dissociate();
            $translation->delete();
        });

        $product_category->delete();

        return $this->redirectWithMessage(RedirectType::DELETE->value, 'admin.product.category.index');
    }

    public function statusUpdate($id) {
        checkAdminHasPermissionAndThrowException('product.category.management');
        $ProductCategory = ProductCategory::find($id);
        $status = $ProductCategory->status == 1 ? 0 : 1;
        $ProductCategory->update(['status' => $status]);

        $notification = __('Updated Successfully');

        return response()->json([
            'success' => true,
            'message' => $notification,
        ]);
    }
}
