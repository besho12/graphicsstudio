<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Modules\Coupon\app\Models\Coupon;
use Modules\Shop\app\Models\Product;

class CartController extends Controller {
    public function addToCart($slug): JsonResponse {
        $qty = request()->query('qty', 1);
        $product = Product::whereSlug($slug)->active()->withCount(['reviews as average_rating' => function ($query) {
            $query->select(DB::raw('coalesce(avg(rating), 0) as average_rating'))->where('status', 1);
        }])->first();

        if ($product) {
            if ($product->type == Product::PHYSICAL_TYPE && $this->stockCheck($product, $qty)) {
                return response()->json(['success' => false, 'message' => __('Product stock out')]);
            }

            if ($product->type == Product::DIGITAL_TYPE && checkPurchased($product->id)) {
                return response()->json(['success' => false, 'message' => __('Already purchased')]);
            }
            $price = $product?->sale_price ? $product?->sale_price : $product?->price;
            $options = [
                'image'          => $product->image,
                'slug'           => $product?->slug,
                'type'           => $product?->type,
                'regular_price'  => $product?->price,
                'sale_price'     => $product?->sale_price,
                'average_rating' => $product?->average_rating,
            ];

            Cart::add($product?->id, $product?->title, $qty, $price, 0, $options);

            $count = __('Cart') . ' <span>(' . Cart::content()->count() . ')</span>';
            $content = view('frontend.pages.shop.partials.cart-sidebar')->render();
            return response()->json(['success' => true, 'count' => $count, 'content' => $content, 'message' => __('Added to cart successfully')]);
        }
        return response()->json(['success' => false, 'message' => __('Not Found!')]);
    }
    public function updateCart(Request $request, $rowId) {
        $item = Cart::get($rowId);
        $cart_page = view('frontend.pages.shop.partials.cart-page-content')->render();
        if (!$item) {
            return response()->json(['success' => false, 'cart_page' => $cart_page, 'message' => __('Not Found!')]);
        }

        $product = Product::find($item?->id);
        if (!$product) {
            return response()->json(['success' => false, 'cart_page' => $cart_page, 'message' => __('Product not found')]);
        }
        if ($product->type == Product::DIGITAL_TYPE) {
            return response()->json(['success' => false, 'cart_page' => $cart_page, 'message' => __('Could not update digital product quantity')]);
        }

        $requestedQty = (int) $request?->qty;
        if ($requestedQty > $product?->qty) {
            return response()->json(['success' => false, 'cart_page' => $cart_page, 'message' => __('Product stock out')]);
        }

        Cart::update($rowId, $request?->qty);
        $count = __('Cart') . ' <span>(' . Cart::content()->count() . ')</span>';
        $sidebar = view('frontend.pages.shop.partials.cart-sidebar')->render();
        $cart_page = view('frontend.pages.shop.partials.cart-page-content')->render();
        $this->clearCouponIfCartEmpty();

        return response()->json(['success' => true, 'count' => $count, 'sidebar' => $sidebar, 'cart_page' => $cart_page, 'message' => __('Updated Successfully')]);
    }
    private function stockCheck(Product $product, $quantity): bool {
        $cartContents = Cart::content();
        foreach ($cartContents as $cartContent) {
            if ($cartContent?->id == $product?->id && ($cartContent?->qty + $quantity) > $product->qty) {
                return true;
            }
        }
        if ($product?->qty == 0 || $quantity > $product->qty) {
            return true;
        }
        return false;
    }
    public function removeFromCart($rowId): JsonResponse {
        $item = Cart::get($rowId);
        if ($item) {
            Cart::remove($rowId);
            $this->clearCouponIfCartEmpty();
            $total_item = Cart::content()->count();
            $count = __('Cart') . ' <span>(' . $total_item . ')</span>';
            $sidebar = view('frontend.pages.shop.partials.cart-sidebar')->render();

            $paymentService = app(\Modules\BasicPayment\app\Services\PaymentMethodService::class);
            $activeGateways = $paymentService->getActiveGatewaysWithDetails();

            $checkout_page = view('frontend.pages.shop.partials.checkout-summary', compact('paymentService', 'activeGateways'))->render();
            $cart_page = view('frontend.pages.shop.partials.cart-page-content')->render();

            return response()->json(['success' => true, 'total_item' => $total_item, 'count' => $count, 'sidebar' => $sidebar, 'checkout_page' => $checkout_page, 'cart_page' => $cart_page, 'message' => __('Item removed from cart')]);
        }
        return response()->json(['success' => false, 'message' => __('Not Found!')]);
    }
    public function apply_coupon(Request $request) {
        $validator = Validator::make($request->all(), ['coupon' => 'required'], ['coupon.required' => __('Coupon is required')]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $coupon = Coupon::where(['coupon_code' => $request?->coupon, 'status' => 'active'])->where('start_date', '<=', now())->where('expired_date', '>=', now())->first();
        $sub_total = Cart::subtotal(2, '.', '');

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => __('Invalid coupon')]);
        }
        if ($sub_total < $coupon?->min_price) {
            return response()->json(['success' => false, 'message' => __('Minimum cart amount not met.')]);
        }

        if ($coupon->expired_date < date('Y-m-d')) {
            return response()->json(['success' => false, 'message' => __('Coupon already expired')]);
        }

        session()->put([
            'coupon_code'      => $coupon?->coupon_code,
            'coupon_min_price' => $coupon?->min_price,
            'discount_type'    => $coupon?->discount_type,
            'discount'         => $coupon?->discount,
        ]);

        $cart_page = view('frontend.pages.shop.partials.cart-page-content')->render();
        return response()->json(['success' => true, 'cart_page' => $cart_page, 'message' => __('Coupon applied successful')]);
    }
    private function clearCouponIfCartEmpty() {
        $cartSubtotal = Cart::subtotal(2, '.', '');
        $minPrice = session()->get('coupon_min_price', 0);

        if (Cart::count() == 0 || $cartSubtotal < $minPrice) {
            session()->forget(['coupon_code', 'discount_type', 'discount', 'coupon_min_price', 'shipping_method_id', 'delivery_charge']);
        }
    }
}
