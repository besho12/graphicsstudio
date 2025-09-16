<?php

namespace Modules\Shop\app\Http\Controllers;

use App\Enums\RedirectType;
use App\Http\Controllers\Controller;
use App\Traits\RedirectHelperTrait;
use Modules\Shop\app\Models\ProductReview;

class ReviewController extends Controller {
    use RedirectHelperTrait;

    public function index() {
        checkAdminHasPermissionAndThrowException('product.management');
        $reviews = ProductReview::with('product.translation')->latest()->paginate(15);
        return view('shop::Product.Reviews.index', compact('reviews'));
    }

    public function show($id) {
        checkAdminHasPermissionAndThrowException('product.management');
        $reviews = ProductReview::with(['user', 'product'])->where('product_id', $id)->paginate(20);
        return view('shop::Product.Reviews.show', compact('reviews'));
    }

    public function destroy($id) {
        checkAdminHasPermissionAndThrowException('product.review.management');
        ProductReview::findOrFail($id)?->delete();
        return $this->redirectWithMessage(RedirectType::DELETE->value);
    }

    public function statusUpdate($id) {
        checkAdminHasPermissionAndThrowException('product.review.management');
        $productReview = ProductReview::find($id);
        if ($productReview) {
            $status = $productReview->status == 1 ? 0 : 1;
            $productReview->update(['status' => $status]);

            $notification = __('Updated Successfully');

            return response()->json([
                'success' => true,
                'message' => $notification,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => __('Failed!'),
        ]);
    }
}
