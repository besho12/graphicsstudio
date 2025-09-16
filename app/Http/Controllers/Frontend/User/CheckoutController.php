<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Traits\RedirectHelperTrait;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Modules\Location\app\Models\Country;
use Modules\Order\app\Models\ShippingMethod;
use Modules\Shop\app\Models\DeliveryAddress;
use Modules\Shop\app\Models\Product;

class CheckoutController extends Controller {
    use RedirectHelperTrait;
    public function index() {
        $applyDeliveryCharge = $this->cleanupPurchasedDigitalItemsInCart();

        $user = userAuth();
        if (Cart::count() === 0) {
            return redirect()->route('shop');
        }

        $countries = Country::select('id')->with(['translation' => function ($query) {
            $query->select('country_id', 'name');
        }])->active()->orderBy('slug')->get();

        $shippingMethods = ShippingMethod::select('id', 'fee', 'is_free', 'minimum_order')->with(['translation' => function ($query) {
            $query->select('shipping_method_id', 'title');
        }])->active()->get();

        $delivery_addresses = DeliveryAddress::select('id', 'title')->where('user_id', $user->id)->get();

        $totalAmount = totalAmount();
        
        $paymentService = app(\Modules\BasicPayment\app\Services\PaymentMethodService::class);
        $activeGateways = $paymentService->getActiveGatewaysWithDetails();

        return view('frontend.pages.shop.checkout', compact('countries', 'delivery_addresses', 'user', 'shippingMethods', 'paymentService', 'activeGateways', 'applyDeliveryCharge'));
    }
    private function cleanupPurchasedDigitalItemsInCart(): bool {
        $cartContents = Cart::content();
        $hasPhysical = false;

        foreach ($cartContents as $item) {
            $isDigital = $item?->options?->type == Product::DIGITAL_TYPE;

            if ($isDigital && checkPurchased($item->id)) {
                Cart::remove($item->rowId);
            }

            if (!$isDigital) {
                $hasPhysical = true;
            }
        }

        return $hasPhysical;
    }
    public function storeBillingAddress(Request $request) {
        $user = userAuth();
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name'  => 'nullable|string|max:255',
            'email'      => 'required|email',
            'phone'      => 'required',
            'title'      => 'required|string|max:255',
            'country_id' => 'required',
            'province'   => 'required',
            'city'       => 'required',
            'address'    => 'required|string',
            'zip_code'   => 'required',
        ], [
            'first_name.required' => __('First name is required'),
            'first_name.string'   => __('First name must be a string.'),
            'first_name.max'      => __('First name may not be greater than 255 characters.'),

            'last_name.string'    => __('Last name must be a string.'),
            'last_name.max'       => __('Last name may not be greater than 255 characters.'),

            'email.required'      => __('Email is required'),
            'email.email'         => __('Please enter a valid email address.'),

            'phone.required'      => __('Phone is required'),

            'title.required'      => __('The title is required.'),
            'title.string'        => __('The title must be a string.'),
            'title.max'           => __('The title may not be greater than 255 characters.'),

            'country_id.required' => __('Country is required'),
            'province.required'   => __('Province is required'),
            'city.required'       => __('City is required'),

            'address.required'    => __('Address is required'),
            'address.string'      => __('The address must be a string.'),

            'zip_code.required'   => __('Zip code is required'),
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 422);
        }
        try {
            $address = DeliveryAddress::create(array_merge(['user_id' => $user->id], $validator->validated()));
            return response()->json([
                'success' => true,
                'html'    => "<option value=\"{$address->id}\" selected>{$address->title}</option>",
            ]);
        } catch (\Exception $e) {
            info($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => __('Something went wrong, please try again'),
            ]);
        }

    }

    public function updateShippingMethod($id) {
        if (!auth()->guard('web')->check()) {
            return response()->json([
                'success' => false,
                'message' => __('Login first'),
            ]);
        }
        $method = ShippingMethod::find($id);
        if ($method) {
            if(request('delivery_charge',false) == 'true'){
                Session::put('delivery_charge', $method->fee);
                Session::put('shipping_method_id', $method->id);
            }else{
                Session::put('delivery_charge', 0);
                Session::put('shipping_method_id', 0);
            }

            $paymentService = app(\Modules\BasicPayment\app\Services\PaymentMethodService::class);
            $activeGateways = $paymentService->getActiveGatewaysWithDetails();
            $checkoutSummary = view('frontend.pages.shop.partials.checkout-summary', compact('paymentService', 'activeGateways'))->render();
            return response()->json(['success' => true, 'checkoutSummary' => $checkoutSummary, 'message' => __('Updated Successfully')]);
        }

        return response()->json([
            'success' => false,
            'message' => __('Something went wrong, please try again'),
        ]);
    }

    public function buyNow($slug) {
        $user = userAuth();
        $product = Product::whereSlug($slug)->firstOrFail();
        $qty = (int) ($product->type == Product::DIGITAL_TYPE ? 1 : floor(request('qty', 1)));

        if ($product->qty === 0) {
            return redirect()->route('single.product', $slug)->with(['message' => __('Out of stock'), 'alert-type' => 'error']);
        }
        if ($product->qty < $qty) {
            return redirect()->route('single.product', $slug)->with(['message' => __('Only') . ' ' . $product->qty . ' ' . __('products are available.'), 'alert-type' => 'error']);
        }
        if ($product->type == Product::DIGITAL_TYPE && checkPurchased($product->id)) {
            return redirect()->route('single.product', $slug)->with(['message' => __('Already purchased'), 'alert-type' => 'error']);
        }

        $countries = Country::select('id')->with(['translation' => function ($query) {
            $query->select('country_id', 'name');
        }])->active()->orderBy('slug')->get();

        $shippingMethods = ShippingMethod::select('id', 'fee', 'is_free', 'minimum_order')->with(['translation' => function ($query) {
            $query->select('shipping_method_id', 'title');
        }])->active()->get();

        $delivery_addresses = DeliveryAddress::select('id', 'title')->where('user_id', $user->id)->get();

        $total_price = $product?->sale_price ? $product?->sale_price : $product?->price;
        $totalAmount = totalAmount($total_price * $qty);

        $applyDeliveryCharge = $product->type == Product::PHYSICAL_TYPE;

        defaultShippingMethod($totalAmount?->total, $applyDeliveryCharge);

        $paymentService = app(\Modules\BasicPayment\app\Services\PaymentMethodService::class);
        $activeGateways = $paymentService->getActiveGatewaysWithDetails();

        return view('frontend.pages.shop.buy-now', compact('product', 'countries', 'delivery_addresses', 'user', 'shippingMethods', 'paymentService', 'activeGateways', 'total_price', 'qty', 'applyDeliveryCharge'));
    }
    public function updateBuyNowShippingMethod($id, $slug) {
        if (!auth()->guard('web')->check()) {
            return response()->json([
                'success' => false,
                'message' => __('Login first'),
            ]);
        }
        $method = ShippingMethod::find($id);
        $product = Product::whereSlug($slug)->first();
        if ($method && $product) {
            if ($product->type == Product::DIGITAL_TYPE) {
                Session::put('shipping_method_id', 0);
                Session::put('delivery_charge', 0);
            } else {
                Session::put('delivery_charge', $method->fee);
                Session::put('shipping_method_id', $method->id);
            }

            $total_price = $product?->sale_price ? $product?->sale_price : $product?->price;
            $paymentService = app(\Modules\BasicPayment\app\Services\PaymentMethodService::class);
            $qty = (int) ($product->type == Product::DIGITAL_TYPE ? 1 : floor(request('qty', 1)));
            $activeGateways = $paymentService->getActiveGatewaysWithDetails();
            $checkoutSummary = view('frontend.pages.shop.partials.buy-now-summary', compact('product', 'total_price', 'qty', 'paymentService', 'activeGateways'))->render();
            return response()->json(['success' => true, 'checkoutSummary' => $checkoutSummary, 'message' => __('Updated Successfully')]);
        }

        return response()->json([
            'success' => false,
            'message' => __('Something went wrong, please try again'),
        ]);
    }
}
