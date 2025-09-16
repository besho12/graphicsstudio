<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use Modules\Shop\app\Models\Product;

class WishListController extends Controller {
    public function update(Product $product) {
        if (!$product) {
            return response()->json(['success' => false, 'message' => __('Not Found!')]);
        }
        $userFavorites = userAuth()->favoriteProducts();

        if ($userFavorites->where('product_id', $product->id)->exists()) {
            $userFavorites->detach($product);
            return response()->json(['success' => true, 'message' => __('Removed from wishlist!')]);
        } else {
            $userFavorites->attach($product);
            return response()->json(['success' => true, 'message' => __('Added to wishlist!')]);
        }
    }

    public function destroy($slug) {
        $product = Product::whereSlug($slug)->first();
        if (!$product) {
            return response()->json(['success' => false, 'message' => __('Not Found!')]);
        }
        userAuth()->favoriteProducts()->detach($product);
        $content = view('frontend.profile.partials.wishlist-card')->render();
        return response()->json(['success' => true, 'content' => $content, 'message' => __('Removed from wishlist!')]);
    }
}
