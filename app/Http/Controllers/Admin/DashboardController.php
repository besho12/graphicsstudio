<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Modules\Blog\app\Models\Blog;
use Modules\Order\app\Models\Order;
use App\Http\Controllers\Controller;
use Modules\Shop\app\Models\Product;
use Modules\NewsLetter\app\Models\NewsLetter;

class DashboardController extends Controller {
    public function dashboard(Request $request) {
        $dataCal = [];
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();
        $first_date = $start->toDateString();
        $lastDayofMonth = $end->toDateString();

        if ($request->filled('year') && $request->filled('month')) {
            $year = $request->input('year');
            $month = $request->input('month');

            $start = Carbon::createFromDate($year, $month, 1)->startOfMonth();
            $end = $start->copy()->endOfMonth();
        } elseif ($request->filled('year')) {
            $year = $request->input('year');

            $start = Carbon::createFromDate($year, 1, 1)->startOfYear();
            $end = $start->copy()->endOfYear();
        }

        $data = Order::selectRaw('DATE(created_at) as date, SUM(amount_usd) as total_price')
            ->where('payment_status', 'success')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('date')
            ->get();

        $dates = [];

        while ($start <= $end) {
            $dates[] = $start->toDateString();
            $start->addDay();
        }

        $dataCal = array_fill_keys($dates, 0);

        foreach ($data as $item) {
            $dataCal[$item->date] = $item->total_price;
        }

        $data = [];
        $data['monthly_data'] = json_encode(array_values($dataCal));
        $data['total_order'] = Order::select('id')->get();
        $data['total_active_product'] = Product::select('id')->active()->get();
        $data['total_inactive_product'] = Product::select('id')->inactive()->get();
        $data['total_product'] = Product::select('id')->get();
        $data['total_user'] = User::select('id')->get();
        $data['total_newsletter'] = NewsLetter::select('id')->get();
        $data['oldestYear'] = Carbon::parse(Order::select('created_at')->orderBy('created_at', 'asc')->first()?->created_at)->year ?? Carbon::now()->year;
        $data['latestYear'] = Carbon::parse(Order::select('created_at')->orderBy('created_at', 'desc')->first()?->created_at)->year ?? Carbon::now()->year;

        $data['monthlyEarning'] = Order::whereBetween('created_at', [$first_date, $lastDayofMonth])->where('payment_status', 'success')->sum('amount_usd');
        $data['totalEarning'] = Order::where('payment_status', 'success')->sum('amount_usd');

        if (checkAdminHasPermission('blog.view')) {
            $data['latestBlogPosts'] = Blog::with([
                'translation'          => function ($query) {
                    $query->select('blog_id', 'title');
                },
                'category'             => function ($query) {
                    $query->select('id', 'slug');
                },
                'category.translation' => function ($query) {
                    $query->select('blog_category_id', 'title');
                }])->withCount(['comments' => function ($query) {$query->active();}])->active()->latest()->take(5)->get();
        }

        if (checkAdminHasPermission('product.management')) {
            $data['latestProducts'] = Product::with([
                'translation'          => function ($query) {
                    $query->select('product_id', 'title');
                }, 'category' => function ($query) {
                    $query->select('id', 'slug');
                },
                'category.translation' => function ($query) {
                    $query->select('product_category_id', 'title');
                }])->withCount(['reviews' => function ($query) {$query->active();}])->active()->latest()->take(5)->get();
        }
        if (checkAdminHasPermission('order.management')) {
            $data['latestOrders'] = Order::with('user')->latest()->take(5)->get();
        }

        if (checkAdminHasPermission('customer.view')) {
            $data['latestCustomers'] = User::select('id', 'name', 'is_banned', 'created_at', 'email_verified_at')->latest()->take(5)->get();
        }
        return view('admin.dashboard', $data);
    }

    public function setLanguage() {
        $action = setLanguage(request('code'));

        if ($action) {
            $notification = __('Language Changed Successfully');
            $notification = ['message' => $notification, 'alert-type' => 'success'];
            return redirect()->back()->with($notification);
        }

        $notification = __('Language Changed Successfully');
        $notification = ['message' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }
    public function setCurrency() {
        $currency = allCurrencies()->where('currency_code', request('currency'))->first();

        if (session()->has('currency_code')) {
            session()->forget('currency_code');
            session()->forget('currency_position');
            session()->forget('currency_icon');
            session()->forget('currency_rate');
        }
        if ($currency) {
            session()->put('currency_code', $currency->currency_code);
            session()->put('currency_position', $currency->currency_position);
            session()->put('currency_icon', $currency->currency_icon);
            session()->put('currency_rate', $currency->currency_rate);

            $notification = __('Currency Changed Successfully');
            $notification = ['message' => $notification, 'alert-type' => 'success'];

            return redirect()->back()->with($notification);
        }
        getSessionCurrency();
        $notification = __('Currency Changed Successfully');
        $notification = ['message' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }
}
