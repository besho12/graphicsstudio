<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\GetGlobalInformationTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Modules\GlobalSetting\app\Models\CustomPagination;
use Modules\Order\app\Models\Order;
use Modules\Order\app\Models\OrderProduct;
use Modules\Shop\app\Models\Product;
use Modules\Subscription\app\Models\SubscriptionPlan;

class DashboardController extends Controller {
    use GetGlobalInformationTrait;
    public function index() {
        $user = User::with([
            'country'             => function ($query) {
                $query->select('id');
            },
            'country.translation' => function ($query) {
                $query->select('country_id', 'name');
            },
        ])->withCount('product_reviews')->withSum('orders', 'amount_usd')->withSum('orders', 'product_qty')->find(userAuth()->id);

        return view('frontend.profile.dashboard', compact('user'));
    }
    public function order() {
        $orders = Order::with('refund')->where('user_id', userAuth()->id)->latest()->paginate(10);

        $paymentService = app(\Modules\BasicPayment\app\Services\PaymentMethodService::class);
        $methods = $paymentService->getActiveGatewaysWithDetails();

        return view('frontend.profile.order', compact('orders', 'methods'));
    }
    public function order_show($order_id) {
        $order = Order::with('user')->where('user_id', userAuth()->id)->where('order_id', $order_id)->firstOrFail();
        return view('frontend.profile.order_show', compact('order'));
    }
    public function invoice($order_id) {
        $order = Order::with('user')->where('user_id', userAuth()->id)->where('order_id', $order_id)->firstOrFail();
        return view('frontend.profile.invoice', compact('order'));
    }
    public function pricing() {
        $per_age = cache('CustomPagination')?->pricing_plan ?? CustomPagination::where('section_name', 'Pricing Plan')->value('item_qty');
        $plans = SubscriptionPlan::select('id', 'plan_price', 'expiration_date', 'button_url')->with([
            'translation' => function ($query) {
                $query->select('subscription_plan_id', 'plan_name', 'short_description', 'description', 'button_text');
            },
        ])->active()->orderBy('serial')->paginate($per_age);

        return view('frontend.profile.pricing', compact('plans'));
    }
    public function digitalProducts() {
        $digital_products = OrderProduct::select('id', 'order_id', 'product_id')->with([
            'product' => function ($q) {
                $q->withCount([
                    'reviews as average_rating' => function ($query) {
                        $query
                            ->select(DB::raw('coalesce(avg(rating), 0) as average_rating'))
                            ->where('status', 1);
                    },
                    'reviews as reviews_count'  => function ($query) {
                        $query->where('status', 1);
                    },
                ]);
            },
        ])->whereHas('order', function ($q) {
            $q->paymentSuccess()->where('user_id', userAuth()->id);
        })->whereHas('product', function ($q) {
            $q->where('type', Product::DIGITAL_TYPE);
        })->paginate(4);

        return view('frontend.profile.digital_products', compact('digital_products'));
    }
    public function download($slug) {
        try {
            $product = Product::whereSlug($slug)->firstOrFail();
            if ($product->type == Product::DIGITAL_TYPE && !checkPurchased($product->id)) {
                return redirect()->back();
            }
            $response = $product->download();
            if (isset($response->type) && $response->type == "error") {
                throw new Exception($response->message);
            }
            return $response;
        } catch (Exception $e) {
            info($e->getMessage());
            return redirect()->back();
        }
    }
}
