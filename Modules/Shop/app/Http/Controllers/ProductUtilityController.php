<?php

namespace Modules\Shop\app\Http\Controllers;

use App\Enums\RedirectType;
use App\Http\Controllers\Controller;
use App\Traits\RedirectHelperTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Modules\Shop\app\Models\Product;
use Modules\Shop\app\Models\ProductImage;

class ProductUtilityController extends Controller {
    use RedirectHelperTrait;
    public function showGallery($id) {
        checkAdminHasPermissionAndThrowException('product.management');
        $gallery = ProductImage::where('product_id', $id)->get();
        $product = Product::findOrFail($id);

        return view('shop::Product.utilities.gallery', compact('product', 'gallery'));
    }

    public function updateGallery(Request $request, $id) {
        checkAdminHasPermissionAndThrowException('product.management');
        foreach ($request->file as $image) {
            $listImage = new ProductImage();
            $listImage->product_id = $id;
            $file_name = file_upload($image, 'uploads/custom-images/');
            $listImage->preview = $file_name;
            $listImage->image = $file_name;
            $listImage->save();
        }
        if ($listImage) {
            return response()->json([
                'message' => __('Images Saved Successfully'),
                'url'     => route('admin.product.gallery', $id),
            ]);
        } else {
            return $this->redirectWithMessage(RedirectType::ERROR->value);
        }
    }

    public function deleteGallery($id) {
        checkAdminHasPermissionAndThrowException('product.management');
        $listImage = ProductImage::findOrFail($id);

        if ($listImage->image && !str($listImage->image)->contains('website/images')) {
            if (@File::exists(public_path($listImage->image))) {
                @unlink(public_path($listImage->image));
            }
        }

        $listImage->delete();

        return $this->redirectWithMessage(RedirectType::DELETE->value);
    }
}
