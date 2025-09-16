<?php

namespace Modules\Order\app\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\RedirectType;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\GlobalMailTrait;
use App\Traits\RedirectHelperTrait;
use Illuminate\Http\Request;
use Modules\Order\app\Models\Order;

class OrderController extends Controller {
    use GlobalMailTrait, RedirectHelperTrait;
    public function index(Request $request) {
        checkAdminHasPermissionAndThrowException('order.management');

        $query = Order::query();
        $query->with('user');

        $query->when($request->filled('keyword'), function ($q) use ($request) {
            $q->where('order_id', 'like', '%' . $request->keyword . '%')->orWhere('transaction_id', 'like', '%' . $request->keyword . '%');
        });

        if ($request->filled(['from_date', 'to_date'])) {
            $from_date = date('Y-m-d 00:00:00', strtotime($request->from_date));
            $to_date = date('Y-m-d 23:59:59', strtotime($request->to_date));
            
            $query->whereBetween('created_at', [$from_date, $to_date]);
        }

        $query->when($request->filled('user'), function ($q) use ($request) {
            $q->where('user_id', $request->user);
        });

        $query->when($request->filled('payment_status'), function ($q) use ($request) {
            $q->where('payment_status', $request->payment_status);
        });

        $orderBy = $request->filled('order_by') && $request->order_by == 1 ? 'asc' : 'desc';

        if ($request->filled('par-page')) {
            $orders = $request->get('par-page') == 'all' ? $query->orderBy('id', $orderBy)->get() : $query->orderBy('id', $orderBy)->paginate($request->get('par-page'))->withQueryString();
        } else {
            $orders = $query->orderBy('id', $orderBy)->paginate(10)->withQueryString();
        }

        $title = __('Order History');

        $users = User::select('name', 'id','email')->active()->get();

        return view('order::index', ['orders' => $orders, 'title' => $title, 'users' => $users]);
    }

    public function pending_order(Request $request) {
        checkAdminHasPermissionAndThrowException('order.management');
 
        $query = Order::query();
        $query->with('user')->where('order_status', 'pending');

        $query->when($request->filled('keyword'), function ($q) use ($request) {
            $q->where('order_id', 'like', '%' . $request->keyword . '%')->orWhere('transaction_id', 'like', '%' . $request->keyword . '%');
        });

        if ($request->filled(['from_date', 'to_date'])) {
            $from_date = date('Y-m-d 00:00:00', strtotime($request->from_date));
            $to_date = date('Y-m-d 23:59:59', strtotime($request->to_date));
            
            $query->whereBetween('created_at', [$from_date, $to_date]);
        }

        $query->when($request->filled('user'), function ($q) use ($request) {
            $q->where('user_id', $request->user);
        });

        $query->when($request->filled('payment_status'), function ($q) use ($request) {
            $q->where('payment_status', $request->payment_status);
        });

        $orderBy = $request->filled('order_by') && $request->order_by == 1 ? 'asc' : 'desc';

        if ($request->filled('par-page')) {
            $orders = $request->get('par-page') == 'all' ? $query->orderBy('id', $orderBy)->get() : $query->orderBy('id', $orderBy)->paginate($request->get('par-page'))->withQueryString();
        } else {
            $orders = $query->orderBy('id', $orderBy)->paginate(10)->withQueryString();
        }

        $title = __('Pending Order');
        $users = User::select('name', 'id','email')->active()->get();

        return view('order::index', ['orders' => $orders, 'title' => $title, 'users' => $users]);
    }

    public function pending_payment(Request $request) {
        checkAdminHasPermissionAndThrowException('order.management');
        $query = Order::query();
        $query->with('user')->where('payment_status', 'pending');

        $query->when($request->filled('keyword'), function ($q) use ($request) {
            $q->where('order_id', 'like', '%' . $request->keyword . '%')->orWhere('transaction_id', 'like', '%' . $request->keyword . '%');
        });

        if ($request->filled(['from_date', 'to_date'])) {
            $from_date = date('Y-m-d 00:00:00', strtotime($request->from_date));
            $to_date = date('Y-m-d 23:59:59', strtotime($request->to_date));
            
            $query->whereBetween('created_at', [$from_date, $to_date]);
        }

        $query->when($request->filled('user'), function ($q) use ($request) {
            $q->where('user_id', $request->user);
        });

        $orderBy = $request->filled('order_by') && $request->order_by == 1 ? 'asc' : 'desc';

        if ($request->filled('par-page')) {
            $orders = $request->get('par-page') == 'all' ? $query->orderBy('id', $orderBy)->get() : $query->orderBy('id', $orderBy)->paginate($request->get('par-page'))->withQueryString();
        } else {
            $orders = $query->orderBy('id', $orderBy)->paginate(10)->withQueryString();
        }

        $title = __('Pending Payment');
        $users = User::select('name', 'id','email')->active()->get();

        return view('order::index', ['orders' => $orders, 'title' => $title, 'users' => $users]);
    }

    public function rejected_payment(Request $request) {
        checkAdminHasPermissionAndThrowException('order.management');
        $query = Order::query();
        $query->with('user')->where('payment_status', 'rejected');

        $query->when($request->filled('keyword'), function ($q) use ($request) {
            $q->where('order_id', 'like', '%' . $request->keyword . '%')->orWhere('transaction_id', 'like', '%' . $request->keyword . '%');
        });

        if ($request->filled(['from_date', 'to_date'])) {
            $from_date = date('Y-m-d 00:00:00', strtotime($request->from_date));
            $to_date = date('Y-m-d 23:59:59', strtotime($request->to_date));
            
            $query->whereBetween('created_at', [$from_date, $to_date]);
        }

        $query->when($request->filled('user'), function ($q) use ($request) {
            $q->where('user_id', $request->user);
        });

        $orderBy = $request->filled('order_by') && $request->order_by == 1 ? 'asc' : 'desc';

        if ($request->filled('par-page')) {
            $orders = $request->get('par-page') == 'all' ? $query->orderBy('id', $orderBy)->get() : $query->orderBy('id', $orderBy)->paginate($request->get('par-page'))->withQueryString();
        } else {
            $orders = $query->orderBy('id', $orderBy)->paginate(10)->withQueryString();
        }

        $title = __('Rejected Payment');
        $users = User::select('name', 'id','email')->active()->get();

        return view('order::index', ['orders' => $orders, 'title' => $title, 'users' => $users]);
    }

    public function show($order_id) {
        checkAdminHasPermissionAndThrowException('order.management');
        $order = Order::where('order_id', $order_id)->firstOrFail();

        return view('order::show', ['order' => $order]);
    }

    public function order_payment_reject(Request $request, $id) {
        checkAdminHasPermissionAndThrowException('order.management');

        $order = Order::findOrFail($id);
        $order->payment_status = OrderStatus::REJECTED->value;
        $order->save();

        //mail send
        try {
            $user = User::findOrFail($order->user_id);
            [$subject, $message] = $this->fetchEmailTemplate('reject_payment', ['user_name' => $user->name, 'order_id' => $order->order_id]);
            $this->sendMail($user->email, $subject, $message);
        } catch (\Exception $e) {
            info($e->getMessage());
        }

        $notification = __('Payment rejected successfully');
        $notification = ['message' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function order_payment_approved(Request $request, $id) {
        checkAdminHasPermissionAndThrowException('order.management');

        $order = Order::findOrFail($id);
        $order->payment_status = OrderStatus::COMPLETED->value;
        $order->save();

        //mail send
        try {
            $user = User::findOrFail($order->user_id);
            [$subject, $message] = $this->fetchEmailTemplate('approved_payment', ['user_name' => $user->name, 'order_id' => $order->order_id]);
            $this->sendMail($user->email, $subject, $message);
        } catch (\Exception $e) {
            info($e->getMessage());
        }

        $notification = __('Payment approved successfully');
        $notification = ['message' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    public function destroy($id) {
        checkAdminHasPermissionAndThrowException('order.management');
        $order = Order::findOrFail($id);
        if ($order->payment_status != 'success') {
            $order->order_products()->delete();
            $order->order_address()->delete();
            $order->delete();
            return $this->redirectWithMessage(RedirectType::DELETE->value, 'admin.orders');
        }
        $notification = __('You cannot delete this order');
        $notification = ['message' => $notification, 'alert-type' => 'error'];

        return redirect()->back()->with($notification);

    }

    public function statusUpdate(Request $request, $id) {
        checkAdminHasPermissionAndThrowException('order.management');

        $order = Order::find($id);
        $order->update(['order_status' => request()->order_status]);

        //mail send
        try {
            $user = User::findOrFail($order->user_id);
            [$subject, $message] = $this->fetchEmailTemplate('order_status', ['user_name' => $user->name, 'order_id' => $order->order_id, 'order_status' => $order->order_status]);
            $this->sendMail($user->email, $subject, $message);
        } catch (\Exception $e) {
            info($e->getMessage());
        }

        return $this->redirectWithMessage(RedirectType::UPDATE->value, 'admin.order', ['id' => $order->order_id]);
    }
}
