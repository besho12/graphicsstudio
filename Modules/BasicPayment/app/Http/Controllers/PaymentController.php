<?php

namespace Modules\BasicPayment\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\BankInformationRequest;
use App\Traits\GetGlobalInformationTrait;
use App\Traits\GlobalMailTrait;
use Closure;
use Exception;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Modules\BasicPayment\app\Enums\BasicPaymentSupportedCurrencyListEnum;
use Modules\BasicPayment\app\Http\Controllers\FrontPaymentController;
use Modules\Coupon\app\Models\Coupon;
use Modules\Coupon\app\Models\CouponHistory;
use Modules\Order\app\Models\Order;
use Modules\Order\app\Models\OrderAddress;
use Modules\Order\app\Models\OrderProduct;
use Modules\Shop\app\Models\Product;
use Razorpay\Api\Api;

class PaymentController extends Controller {
    use GetGlobalInformationTrait, GlobalMailTrait;
    private $paymentService;
    public function __construct() {
        $this->paymentService = app(\Modules\BasicPayment\app\Services\PaymentMethodService::class);
        $this->middleware(function (Request $request, Closure $next) {
            if (session()->has('order') || Route::is('payment') || Route::is('place.order')) {
                return $next($request);
            }
            return redirect()->back()->with(['message' => __('Not Found!'), 'alert-type' => 'error']);
        });
    }
    public function placeOrder(Request $request, $method) {
        $user = userAuth();

        $validator = $this->validatePlaceOrderRequest($request, $user);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 422);
        }
        $buy_now = false;
        $product_qty = Cart::count();

        if ($buy_slug = $request->query('buyNow')) {
            $buy_product = Product::whereSlug($buy_slug)->first();
            $product_qty = (int) ($buy_product->type == Product::DIGITAL_TYPE ? 1 : floor(request('qty', 1)));

            if ($buy_product->qty === 0) {
                return response()->json(['status' => false, 'message' => __('Out of stock')]);
            }
            if ($buy_product->qty < $product_qty) {
                return response()->json(['status' => false, 'message' => __('Only') . ' ' . $buy_product->qty . ' ' . __('products are available.')]);
            }
            $buy_now = (bool) $buy_product;
        }

        if (Cart::count() == 0 && !$buy_now) {
            $this->paymentService->removeSessions();
            return response()->json(['status' => false, 'message' => __('Cart is empty')]);
        }

        $activeGateways = array_keys($this->paymentService->getActiveGatewaysWithDetails());
        if (!in_array($method, $activeGateways)) {
            return response()->json(['status' => false, 'message' => __('The selected payment method is invalid.')]);
        }
        if (!$this->paymentService->isCurrencySupported($method)) {
            $supportedCurrencies = $this->paymentService->getSupportedCurrencies($method);
            return response()->json(['status' => false, 'message' => __('You are trying to use unsupported currency'), 'supportCurrency' => sprintf(
                '%s %s: %s',
                strtoupper($method),
                __('supports only the following currencies'),
                implode(', ', $supportedCurrencies)
            )]);
        }

        try {
            if ($buy_now) {
                $sub_total = $buy_product?->sale_price ? $buy_product?->sale_price : $buy_product?->price;
                $totalAmount = totalAmount($sub_total * $product_qty);
            } else {
                $sub_total = Cart::subtotal();
                $totalAmount = totalAmount();
            }
            $delivery_charge = session('delivery_charge', 0);

            $payable_amount = $totalAmount->total + $delivery_charge;
            $calculatePayableCharge = $this->paymentService->getPayableAmount($method, $payable_amount);

            DB::beginTransaction();

            $paid_amount = $calculatePayableCharge?->payable_amount + $calculatePayableCharge?->gateway_charge;

            if (in_array($method, ['Razorpay', 'Stripe'])) {
                $allCurrencyCodes = BasicPaymentSupportedCurrencyListEnum::getStripeSupportedCurrencies();

                if (in_array(Str::upper($calculatePayableCharge?->currency_code), $allCurrencyCodes['non_zero_currency_codes'])) {
                    $paid_amount = $paid_amount;
                } elseif (in_array(Str::upper($calculatePayableCharge?->currency_code), $allCurrencyCodes['three_digit_currency_codes'])) {
                    $paid_amount = (int) rtrim(strval($paid_amount), '0');
                } else {
                    $paid_amount = floatval($paid_amount / 100);
                }
            }
            $order = new Order();
            $order->user_id = $user->id;
            $order->order_id = substr(rand(0, time()), 0, 10);
            $order->product_qty = $product_qty;

            $order->sub_total_usd = $sub_total;
            $order->order_tax_usd = $totalAmount->tax;
            $order->discount_usd = $totalAmount->discount;
            $order->delivery_charge_usd = $delivery_charge;
            $order->amount_usd = $payable_amount;

            $order->sub_total = currency($sub_total, false);
            $order->order_tax = currency($totalAmount->tax, false);
            $order->discount = currency($totalAmount->discount, false);
            $order->delivery_charge = currency($delivery_charge, false);
            $order->paid_amount = $paid_amount;

            $order->gateway_charge = $calculatePayableCharge?->gateway_charge;
            $order->payable_with_charge = $calculatePayableCharge?->payable_with_charge;
            $order->payable_currency = $calculatePayableCharge?->currency_code;

            $order->payment_method = $method;
            $order->payable_currency = $calculatePayableCharge?->currency_code;
            $order->transaction_id = null;
            $order->payment_status = 'pending';
            $order->order_status = 'draft';
            $order->payment_details = null;
            $order->save();

            $this->orderAddressStore($user, $order->id, $request);

            if ($buy_now) {
                $orderProduct = new OrderProduct();
                $orderProduct->order_id = $order->id;
                $orderProduct->product_id = $buy_product->id;
                $orderProduct->product_name = $buy_product->title;
                $orderProduct->qty = $product_qty;

                $orderProduct->unit_price_usd = $sub_total;
                $orderProduct->total_usd = $sub_total * $product_qty;

                $product_unit_price = currency($sub_total, false);
                $product_total = currency(($sub_total * $product_qty), false);

                $orderProduct->unit_price = $product_unit_price;
                $orderProduct->total = $product_total;

                $orderProduct->save();

                //Product stock manage
                if($buy_product->type == Product::PHYSICAL_TYPE){
                    $qty = $buy_product->qty - $product_qty;
                    $buy_product->qty = $qty;
                    $buy_product->save();
                }
            } else {
                $cartContents = Cart::content();

                foreach ($cartContents as $key => $cartContent) {

                    $product = Product::find($cartContent->id);
                    $orderProduct = new OrderProduct();
                    $orderProduct->order_id = $order->id;
                    $orderProduct->product_id = $product->id;
                    $orderProduct->product_name = $cartContent->name;
                    $orderProduct->qty = $cartContent->qty;

                    $orderProduct->unit_price_usd = $cartContent->price;
                    $orderProduct->total_usd = $cartContent->qty * $cartContent->price;

                    $product_unit_price = currency($cartContent->price, false);
                    $product_total = currency(($cartContent->price * $cartContent->qty), false);

                    $orderProduct->unit_price = $product_unit_price;
                    $orderProduct->total = $product_total;

                    $orderProduct->save();

                    //Product stock manage
                    if($product->type == Product::PHYSICAL_TYPE){
                        $qty = $product->qty - $cartContent->qty;
                        $product->qty = $qty;
                        $product->save();
                    }
                }

            }

            $json_module_data = file_get_contents(base_path('modules_statuses.json'));
            $module_status = json_decode($json_module_data);

            if ($module_status->Coupon) {
                if (session()->get('coupon_code') && session()->get('discount')) {

                    $coupon = Coupon::where(['coupon_code' => session()->get('coupon_code')])->first();

                    if ($coupon) {
                        $history = new CouponHistory();
                        $history->order_id = $order->id;
                        $history->user_id = $user->id;
                        $history->author_id = $coupon->author_id;
                        $history->coupon_code = $coupon->coupon_code;
                        $history->coupon_id = $coupon->id;
                        $history->discount_amount = $totalAmount->discount;
                        $history->save();

                    }
                    session()->forget(
                        [
                            'coupon_code',
                            'discount_type',
                            'discount',
                            'coupon_min_price',
                        ]);
                }
            }
            DB::commit();
            if (! $buy_now) {
                Cart::destroy();
            }


            try {
                $order_details = "<table class='product-details'><tr><th>Product Name</th><th>Qty</th><th>Unit Price</th><th>Total</th></tr>";
                foreach ($order?->order_products as $key => $order_product) {
                    $orderProduct = OrderProduct::find($order_product->id);

                    $orderProduct->unit_price = currency($order_product->unit_price_usd, false);
                    $orderProduct->total = currency(($order_product->total_usd), false);
                    $orderProduct->save();

                    $order_details .= '<tr>';
                    $order_details .= '<td>' . $order_product->product_name . '</td>';
                    $order_details .= '<td>' . $order_product->qty . '</td>';
                    $order_details .= '<td>' . specific_currency_with_icon($order->payable_currency, $orderProduct->unit_price) . '</td>';
                    $order_details .= '<td>' . specific_currency_with_icon($order->payable_currency, $orderProduct->total) . '</td>';
                    $order_details .= '</tr>';

                }
                $order_details .= "</table>";

                $str_replace = [
                    'email'           => userAuth()->email,
                    'user_name'       => userAuth()->name,
                    'sub_total'       => specific_currency_with_icon($order->payable_currency, $order->sub_total),
                    'discount'        => specific_currency_with_icon($order->payable_currency, $order->discount),
                    'tax'             => specific_currency_with_icon($order->payable_currency, $order->order_tax),
                    'delivery_charge' => specific_currency_with_icon($order->payable_currency, $order->delivery_charge),
                    'total_amount'    => specific_currency_with_icon($order->payable_currency, $order->paid_amount),
                    'payment_method'  => $order->payment_method,
                    'payment_status'  => $order->payment_status,
                    'order_date'      => $order?->created_at?->format('d-m-Y'),
                    'order_status'    => $order->order_status,
                    'order_detail'    => $order_details,
                ];
                [$subject, $message] = $this->fetchEmailTemplate('order_mail', $str_replace);
                $this->sendMail(userAuth()->email, $subject, $message);
            } catch (Exception $e) {
                info($e->getMessage());
            }

            return response()->json(['success' => true, 'message' => __('Order Successfully Created.'), 'order_id' => $order?->order_id]);
        } catch (Exception $e) {
            DB::rollBack();
            info($e->getMessage());
            return response()->json(['status' => false, 'message' => __('Payment Failed')]);
        }

    }
    private function validatePlaceOrderRequest($request, $user) {
        $rules = [
            'billing_address' => 'required|exists:delivery_addresses,id,user_id,' . $user->id,
        ];
        if ($request->same_as_shipping != 'on') {
            $rules = array_merge($rules, [
                'shipping_first_name' => 'required|string|max:255',
                'shipping_last_name'  => 'nullable|string|max:255',
                'shipping_email'      => 'required|email',
                'shipping_phone'      => 'required',
                'shipping_country'    => 'required',
                'shipping_province'   => 'required',
                'shipping_city'       => 'required',
                'shipping_address'    => 'required|string',
                'shipping_zip_code'   => 'required',
            ]);
        }
        return Validator::make($request->all(), $rules, [
            'billing_address.required'     => __('Billing address is required'),
            'billing_address.exists'       => __('The selected billing address  is invalid.'),

            'shipping_first_name.required' => __('First name is required'),
            'shipping_first_name.string'   => __('First name must be a string.'),
            'shipping_first_name.max'      => __('First name may not be greater than 255 characters.'),

            'shipping_last_name.string'    => __('Last name must be a string.'),
            'shipping_last_name.max'       => __('Last name may not be greater than 255 characters.'),

            'shipping_email.required'      => __('Email is required'),
            'shipping_email.email'         => __('Please enter a valid email address.'),

            'shipping_phone.required'      => __('Phone is required'),

            'title.required'               => __('The title is required.'),
            'title.string'                 => __('The title must be a string.'),
            'title.max'                    => __('The title may not be greater than 255 characters.'),

            'shipping_country.required'    => __('Country is required'),
            'shipping_province.required'   => __('Province is required'),
            'shipping_city.required'       => __('City is required'),

            'shipping_address.required'    => __('Address is required'),
            'shipping_address.string'      => __('The address must be a string.'),

            'shipping_zip_code.required'   => __('Zip code is required'),
        ]);
    }
    private function orderAddressStore($user, $order_id, $request) {
        try {
            $billing_address = $user->delivery_address()->findOrFail($request->billing_address);

            $orderAddress = new OrderAddress();
            $orderAddress->order_id = $order_id;
            $orderAddress->billing_first_name = $billing_address?->first_name;
            $orderAddress->billing_last_name = $billing_address?->last_name ?? null;
            $orderAddress->billing_email = $billing_address?->email;
            $orderAddress->billing_phone = $billing_address?->phone;
            $orderAddress->billing_address = $billing_address?->address;
            $orderAddress->billing_country = $billing_address?->country->name;
            $orderAddress->billing_state = $billing_address?->province;
            $orderAddress->billing_city = $billing_address?->city;
            $orderAddress->billing_zip_code = $billing_address?->zip_code;

            if ($request->same_as_shipping == 'on') {
                $orderAddress->shipping_first_name = $billing_address?->first_name;
                $orderAddress->shipping_last_name = $billing_address?->last_name ?? null;
                $orderAddress->shipping_email = $billing_address?->email;
                $orderAddress->shipping_phone = $billing_address?->phone;
                $orderAddress->shipping_address = $billing_address?->address;
                $orderAddress->shipping_country = $billing_address?->country->name;
                $orderAddress->shipping_state = $billing_address?->province;
                $orderAddress->shipping_city = $billing_address?->city;
                $orderAddress->shipping_zip_code = $billing_address?->zip_code;
            } else {
                $orderAddress->shipping_first_name = $request->shipping_first_name;
                $orderAddress->shipping_last_name = $request->shipping_last_name ?? null;
                $orderAddress->shipping_email = $request->shipping_email;
                $orderAddress->shipping_phone = $request->shipping_phone;
                $orderAddress->shipping_address = $request->shipping_address;
                $orderAddress->shipping_country = $request->shipping_country;
                $orderAddress->shipping_state = $request->shipping_province;
                $orderAddress->shipping_city = $request->shipping_city;
                $orderAddress->shipping_zip_code = $request->shipping_zip_code;
            }

            if ($orderAddress->save()) {
                return true;
            } else {
                throw new Exception('Failed to save order address.');
            }
        } catch (Exception $e) {
            throw new Exception('Error while saving order address: ' . $e->getMessage());
        }
    }
    public function index() {
        $order_id = request('order_id', null);
        $user = userAuth();

        $order = $user?->orders()->with('order_products.product')->draft()->where('order_id', $order_id)->first();

        if (!$order) {
            $notification = [
                'message'    => __('Payment failed, please try again'),
                'alert-type' => 'error',
            ];
            return redirect()->route('order-failed')->with($notification);
        }
        $paymentMethod = $order->payment_method;
        if (!$this->paymentService->isActive($paymentMethod)) {
            $notification = [
                'message'    => __('The selected payment method is now inactive.'),
                'alert-type' => 'error',
            ];
            return redirect()->back()->with($notification);
        }

        $calculatePayableCharge = $this->paymentService->getPayableAmount($paymentMethod, $order?->amount_usd, $order?->payable_currency);

        Session::put('order', $order);
        Session::put('payable_currency', $order?->payable_currency);
        Session::put('paid_amount', $calculatePayableCharge?->payable_with_charge);

        $paymentService = $this->paymentService;
        $view = $this->paymentService->getBladeView($paymentMethod);
        return view($view, compact('order', 'paymentService', 'paymentMethod', 'user'));
    }
    public function payment_success() {
        $order = session()->get('order');
        $after_success_transaction = session()->get('after_success_transaction', null);
        $payment_details = session()->get('payment_details', null);
        $paid_amount = session()->get('paid_amount', $order->paid_amount);
        $payable_with_charge = session()->get('payable_with_charge', $order->payable_with_charge);
        $gateway_charge = session()->get('gateway_charge', $order->gateway_charge);
        $payable_currency = session()->get('payable_currency');

        try {
            $pendingMethods = [$this->paymentService::BANK_PAYMENT, $this->paymentService::HAND_CASH];
            $payment_status = in_array($order->payment_method, $pendingMethods) ? 'pending' : 'success';

            $payment_details = $order->payment_method == $this->paymentService::BANK_PAYMENT ? $payment_details : json_encode($payment_details);

            $order->gateway_charge = $gateway_charge;
            $order->payable_with_charge = $payable_with_charge;
            $order->paid_amount = $paid_amount;
            $order->payable_currency = $payable_currency;

            $order->transaction_id = $after_success_transaction;
            $order->payment_status = $payment_status;
            $order->order_status = 'pending';
            $order->payment_details = $payment_details;
            $order->save();

            try {
                $user = userAuth();
                [$subject, $message] = $this->fetchEmailTemplate('approved_payment', ['user_name' => $user->name, 'order_id' => $order->order_id]);
                $this->sendMail($user->email, $subject, $message);
            } catch (Exception $e) {
                info($e->getMessage());
            }

            $this->paymentService->removeSessions();

            $notification = __('Order Successfully Created.');
            $notification = ['message' => $notification, 'alert-type' => 'success'];

            return to_route('order-success')->with($notification);
        } catch (Exception $e) {
            info($e->getMessage());
            $notification = __('Payment failed, please try again');
            $notification = ['message' => $notification, 'alert-type' => 'error'];

            return redirect()->route('order-failed')->with($notification);
        }
    }

    public function payment_failed() {
        $this->paymentService->removeSessions();
        $notification = __('Payment failed, please try again');
        $notification = ['message' => $notification, 'alert-type' => 'error'];
        return redirect()->route('order-failed')->with($notification);
    }
    public function pay_via_bank(BankInformationRequest $request) {
        $bankDetails = json_encode($request->only(['bank_name', 'account_number', 'routing_number', 'branch', 'transaction']));

        $allPayments = Order::whereNotNull('payment_details')->get();

        foreach ($allPayments as $payment) {
            $paymentDetailsJson = json_decode($payment->payment_details, true);

            if (isset($paymentDetailsJson['account_number']) && $paymentDetailsJson['account_number'] == $request->account_number) {
                if (isset($paymentDetailsJson['transaction']) && $paymentDetailsJson['transaction'] == $request->transaction) {
                    $notification = __('Payment failed, transaction already exist');
                    $notification = ['message' => $notification, 'alert-type' => 'error'];

                    return redirect()->back()->with($notification);
                }
            }
        }
        Session::put('after_success_transaction', $request->transaction);
        Session::put('payment_details', $bankDetails);

        return $this->payment_success();
    }
    public function pay_cash_on_delivery() {
        Session::put('after_success_transaction', 'hand_cash');
        return $this->payment_success();
    }
    public function pay_via_paypal() {
        $basic_payment = $this->get_basic_payment_info();
        $paypal_credentials = (object) [
            'paypal_client_id'    => $basic_payment->paypal_client_id,
            'paypal_secret_key'   => $basic_payment->paypal_secret_key,
            'paypal_account_mode' => $basic_payment->paypal_account_mode,
        ];

        $after_success_url = route('payment-success');
        $after_failed_url = route('payment-failed');

        $paypal_payment = new FrontPaymentController();

        return $paypal_payment->pay_with_paypal($paypal_credentials, $after_success_url, $after_failed_url);
    }
    public function pay_via_stripe() {
        $basic_payment = $this->get_basic_payment_info();

        // Set your Stripe API secret key
        \Stripe\Stripe::setApiKey($basic_payment?->stripe_secret);

        $after_failed_url = route('payment-failed');

        session()->put('after_failed_url', $after_failed_url);

        $payable_currency = session()->get('payable_currency');
        $paid_amount = session()->get('paid_amount');

        $allCurrencyCodes = $this->paymentService->getSupportedCurrencies($this->paymentService::STRIPE);

        if (in_array(Str::upper($payable_currency), $allCurrencyCodes['non_zero_currency_codes'])) {
            $payable_with_charge = $paid_amount;
        } elseif (in_array(Str::upper($payable_currency), $allCurrencyCodes['three_digit_currency_codes'])) {
            $convertedCharge = (string) $paid_amount . '0';
            $payable_with_charge = (int) $convertedCharge;
        } else {
            $payable_with_charge = (int) ($paid_amount * 100);
        }

        // Create a checkout session
        $checkoutSession = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items'           => [[
                'price_data' => [
                    'currency'     => $payable_currency,
                    'unit_amount'  => $payable_with_charge,
                    'product_data' => [
                        'name' => cache()->get('setting')->app_name,
                    ],
                ],
                'quantity'   => 1,
            ]],
            'mode'                 => 'payment',
            'success_url'          => url('/pay-via-stripe') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'           => $after_failed_url,
        ]);

        // Redirect to the checkout session URL
        return redirect()->away($checkoutSession->url);

    }
    public function stripe_success(Request $request) {
        $after_success_url = route('payment-success');
        $basic_payment = $this->get_basic_payment_info();

        // Assuming the Checkout Session ID is passed as a query parameter
        $session_id = $request->query('session_id');
        if ($session_id) {
            \Stripe\Stripe::setApiKey($basic_payment->stripe_secret);

            $session = \Stripe\Checkout\Session::retrieve($session_id);

            $paymentDetails = [
                'transaction_id' => $session->payment_intent,
                'amount'         => $session->amount_total,
                'currency'       => $session->currency,
                'payment_status' => $session->payment_status,
                'created'        => $session->created,
            ];
            session()->put('after_success_url', $after_success_url);
            session()->put('after_success_transaction', $session->payment_intent);
            session()->put('payment_details', $paymentDetails);

            return redirect($after_success_url);
        }

        $after_failed_url = session()->get('after_failed_url');
        return redirect($after_failed_url);
    }
    public function pay_via_razorpay(Request $request) {
        $payment_setting = $this->get_basic_payment_info();

        $after_success_url = route('payment-success');
        $after_failed_url = route('payment-failed');

        $razorpay_credentials = (object) [
            'razorpay_key'    => $payment_setting->razorpay_key,
            'razorpay_secret' => $payment_setting->razorpay_secret,
        ];

        return $this->pay_with_razorpay($request, $razorpay_credentials, $request->payable_amount, $after_success_url, $after_failed_url);

    }
    public function pay_with_razorpay(Request $request, $razorpay_credentials, $payable_amount, $after_success_url, $after_failed_url) {
        $input = $request->all();
        $api = new Api($razorpay_credentials->razorpay_key, $razorpay_credentials->razorpay_secret);
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
        if (count($input) && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(['amount' => $payment['amount']]);

                $paymentDetails = [
                    'transaction_id' => $response->id,
                    'amount'         => $response->amount,
                    'currency'       => $response->currency,
                    'fee'            => $response->fee,
                    'description'    => $response->description,
                    'payment_method' => $response->method,
                    'status'         => $response->status,
                ];

                Session::put('after_success_url', $after_success_url);
                Session::put('after_failed_url', $after_failed_url);
                Session::put('after_success_transaction', $response->id);
                Session::put('payment_details', $paymentDetails);

                return redirect($after_success_url);

            } catch (Exception $e) {
                info($e->getMessage());
                return redirect($after_failed_url);
            }
        } else {
            return redirect($after_failed_url);
        }

    }
    public function flutterwave_payment(Request $request) {
        $payment_setting = $this->get_basic_payment_info();
        $curl = curl_init();
        $tnx_id = $request->tnx_id;
        $url = "https://api.flutterwave.com/v3/transactions/$tnx_id/verify";
        $token = $payment_setting?->flutterwave_secret_key;
        curl_setopt_array($curl, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'GET',
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json',
                "Authorization: Bearer $token",
            ],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($response);
        if ($response->status == 'success') {
            $paymentDetails = [
                'status'            => $response->status,
                'trx_id'            => $tnx_id,
                'amount'            => $response?->data?->amount,
                'amount_settled'    => $response?->data?->amount_settled,
                'currency'          => $response?->data?->currency,
                'charged_amount'    => $response?->data?->charged_amount,
                'app_fee'           => $response?->data?->app_fee,
                'merchant_fee'      => $response?->data?->merchant_fee,
                'card_last_4digits' => $response?->data?->card?->last_4digits,
            ];
            Session::put('payment_details', $paymentDetails);
            Session::put('after_success_transaction', $tnx_id);

            return response()->json(['message' => 'Payment Success.']);

        } else {
            $notification = __('Payment failed, please try again');
            return response()->json(['message' => $notification], 403);
        }

    }
    public function paystack_payment(Request $request) {
        $payment_setting = $this->get_basic_payment_info();

        $reference = $request->reference;
        $transaction = $request->tnx_id;
        $secret_key = $payment_setting?->paystack_secret_key;
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL            => "https://api.paystack.co/transaction/verify/$reference",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'GET',
            CURLOPT_HTTPHEADER     => [
                "Authorization: Bearer $secret_key",
                'Cache-Control: no-cache',
            ],
        ]);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $final_data = json_decode($response);
        if ($final_data->status == true) {
            $paymentDetails = [
                'status'             => $final_data?->data?->status,
                'transaction_id'     => $transaction,
                'requested_amount'   => $final_data?->data->requested_amount,
                'amount'             => $final_data?->data?->amount,
                'currency'           => $final_data?->data?->currency,
                'gateway_response'   => $final_data?->data?->gateway_response,
                'paid_at'            => $final_data?->data?->paid_at,
                'card_last_4_digits' => $final_data?->data->authorization?->last4,
            ];
            Session::put('payment_details', $paymentDetails);
            Session::put('after_success_transaction', $transaction);
            return response()->json(['message' => 'Payment Success.']);
        } else {
            $notification = __('Payment failed, please try again');
            return response()->json(['message' => $notification], 403);
        }
    }
    public function pay_via_mollie() {
        $after_success_url = route('payment-success');
        $after_failed_url = route('payment-failed');

        session()->put('after_success_url', $after_success_url);
        session()->put('after_failed_url', $after_failed_url);

        $payment_setting = $this->get_basic_payment_info();

        $mollie_credentials = (object) [
            'mollie_key' => $payment_setting->mollie_key,
        ];

        return $this->pay_with_mollie($mollie_credentials);
    }
    public function pay_with_mollie($mollie_credentials) {
        $payable_currency = session()->get('payable_currency');
        $paid_amount = session()->get('paid_amount');

        try {
            $mollie = new \Mollie\Api\MollieApiClient();
            $mollie->setApiKey($mollie_credentials->mollie_key);

            $payment = $mollie->payments->create([
                "amount"      => [
                    "currency" => "$payable_currency",
                    "value"    => "$paid_amount",
                ],
                "description" => userAuth()?->name,
                "redirectUrl" => route('mollie-payment-success'),
            ]);
            $payment = $mollie->payments->get($payment->id);

            session()->put('payment_id', $payment->id);
            session()->put('mollie_credentials', $mollie_credentials);

            return redirect($payment->getCheckoutUrl(), 303);

        } catch (Exception $ex) {
            info($ex->getMessage());
            return redirect()->route('payment-failed')->with(['message' => __('Payment failed, please try again'), 'alert-type' => 'error']);
        }

    }

    public function mollie_payment_success() {
        $mollie_credentials = Session::get('mollie_credentials');

        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey($mollie_credentials->mollie_key);
        $payment = $mollie->payments->get(session()->get('payment_id'));

        if ($payment->isPaid()) {
            $paymentDetails = [
                'transaction_id' => $payment->id,
                'amount'         => $payment->amount->value,
                'currency'       => $payment->amount->currency,
                'fee'            => $payment->settlementAmount->value . ' ' . $payment->settlementAmount->currency,
                'description'    => $payment->description,
                'payment_method' => $payment->method,
                'status'         => $payment->status,
                'paid_at'        => $payment->paidAt,
            ];

            Session::put('payment_details', $paymentDetails);
            Session::put('after_success_transaction', session()->get('payment_id'));

            $after_success_url = Session::get('after_success_url');

            return redirect($after_success_url);

        } else {
            $after_failed_url = Session::get('after_failed_url');
            return redirect($after_failed_url);
        }
    }
    public function pay_via_instamojo() {
        $after_success_url = route('payment-success');
        $after_failed_url = route('payment-failed');

        session()->put('after_success_url', $after_success_url);
        session()->put('after_failed_url', $after_failed_url);

        $payment_setting = $this->get_basic_payment_info();

        $instamojo_credentials = (object) [
            'instamojo_api_key'    => $payment_setting->instamojo_api_key,
            'instamojo_auth_token' => $payment_setting->instamojo_auth_token,
            'account_mode'         => $payment_setting->instamojo_account_mode,
        ];

        return $this->pay_with_instamojo($instamojo_credentials);
    }
    public function pay_with_instamojo($instamojo_credentials) {
        $payable_currency = session()->get('payable_currency');
        $paid_amount = session()->get('paid_amount');

        $environment = $instamojo_credentials->account_mode;
        $api_key = $instamojo_credentials->instamojo_api_key;
        $auth_token = $instamojo_credentials->instamojo_auth_token;

        if ($environment == 'Sandbox') {
            $url = 'https://test.instamojo.com/api/1.1/';
        } else {
            $url = 'https://www.instamojo.com/api/1.1/';
        }

        try {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url . 'payment-requests/');
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER,
                ["X-Api-Key:$api_key",
                    "X-Auth-Token:$auth_token"]);
            $payload = [
                'purpose'                 => env('APP_NAME'),
                'amount'                  => $paid_amount,
                'phone'                   => '918160651749',
                'buyer_name'              => userAuth()?->name,
                'redirect_url'            => route('instamojo-success'),
                'send_email'              => true,
                'webhook'                 => 'http://www.example.com/webhook/',
                'send_sms'                => true,
                'email'                   => userAuth()?->email,
                'allow_repeated_payments' => false,
            ];
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
            $response = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($response);
            session()->put('instamojo_credentials', $instamojo_credentials);

            if (!empty($response?->payment_request?->longurl)) {
                return redirect($response?->payment_request?->longurl);
            } else {
                return redirect()->route('payment-failed')->with(['message' => __('Payment failed, please try again'), 'alert-type' => 'error']);
            }

        } catch (Exception $ex) {
            info($ex->getMessage());
            return redirect()->route('payment-failed')->with(['message' => __('Payment failed, please try again'), 'alert-type' => 'error']);
        }

    }
    public function instamojo_success(Request $request) {

        $instamojo_credentials = Session::get('instamojo_credentials');

        $input = $request->all();
        $environment = $instamojo_credentials->account_mode;
        $api_key = $instamojo_credentials->instamojo_api_key;
        $auth_token = $instamojo_credentials->instamojo_auth_token;

        if ($environment == 'Sandbox') {
            $url = 'https://test.instamojo.com/api/1.1/';
        } else {
            $url = 'https://www.instamojo.com/api/1.1/';
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . 'payments/' . $request->get('payment_id'));
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            ["X-Api-Key:$api_key",
                "X-Auth-Token:$auth_token"]);
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            $after_failed_url = Session::get('after_failed_url');

            return redirect($after_failed_url);
        } else {
            $data = json_decode($response);
        }

        if ($data->success == true) {
            if ($data->payment->status == 'Credit') {
                Session::put('after_success_transaction', $request->get('payment_id'));
                Session::put('paid_amount', $data->payment->amount);
                $after_success_url = Session::get('after_success_url');

                return redirect($after_success_url);
            }
        } else {
            $after_failed_url = Session::get('after_failed_url');

            return redirect($after_failed_url);
        }
    }
}
