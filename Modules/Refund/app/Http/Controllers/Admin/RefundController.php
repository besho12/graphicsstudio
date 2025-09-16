<?php

namespace Modules\Refund\app\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\GlobalMailTrait;
use Modules\Order\app\Models\Order;
use App\Http\Controllers\Controller;
use Modules\Refund\app\Models\RefundRequest;

class RefundController extends Controller {
    use GlobalMailTrait;
    public function index() {
        checkAdminHasPermissionAndThrowException('refund.management');
        $refund_requests = RefundRequest::with('user', 'order')->latest()->get();
        $title = __('Refund History');
        return view('refund::admin.index', ['refund_requests' => $refund_requests, 'title' => $title]);
    }

    public function pending_refund_request() {
        checkAdminHasPermissionAndThrowException('refund.management');
        $refund_requests = RefundRequest::with('user', 'order')->where('status', 'pending')->latest()->get();
        $title = __('Pending Refund');
        return view('refund::admin.index', ['refund_requests' => $refund_requests, 'title' => $title]);
    }

    public function rejected_refund_request() {
        checkAdminHasPermissionAndThrowException('refund.management');
        $refund_requests = RefundRequest::with('user', 'order')->where('status', 'rejected')->latest()->get();
        $title = __('Rejected Refund');
        return view('refund::admin.index', ['refund_requests' => $refund_requests, 'title' => $title]);
    }

    public function complete_refund_request() {
        checkAdminHasPermissionAndThrowException('refund.management');
        $refund_requests = RefundRequest::with('user', 'order')->where('status', 'success')->latest()->get();
        $title = __('Complete Refund');
        return view('refund::admin.index', ['refund_requests' => $refund_requests, 'title' => $title]);
    }

    public function show($id) {
        checkAdminHasPermissionAndThrowException('refund.management');
        $refund_request = RefundRequest::with('user', 'order')->findOrFail($id);
        return view('refund::admin.show', ['refund_request' => $refund_request]);
    }

    public function destroy($id) {
        checkAdminHasPermissionAndThrowException('refund.management');
        $refund_request = RefundRequest::findOrFail($id);
        $refund_request->delete();

        $notification = __('Deleted Successfully');
        $notification = ['message' => $notification, 'alert-type' => 'success'];

        return redirect()->route('admin.refund-request')->with($notification);
    }

    public function approved_refund_request(Request $request, $id) {
        checkAdminHasPermissionAndThrowException('refund.management');
        $request->validate([
            'refund_amount' => 'required|numeric',
            'admin_response' => 'required|string',
        ], [
            'refund_amount.required' => __('Amount is required'),
            'refund_amount.numeric'  => __('Amount should be numeric'),
            'admin_response.required' => __('The Note is required'),
            'admin_response.string' => __('The Note must be a string.'),
        ]);

        $refund_request = RefundRequest::findOrFail($id);
        $refund_request->refund_amount = $request->refund_amount;
        $refund_request->admin_response = $request->admin_response;
        $refund_request->status = 'success';
        $refund_request->save();

        $order = Order::where('order_id',$refund_request->order_id)->first();
        $order->payment_status = 'refund';
        $order->order_status = 'refund';
        $order->save();

        $user = User::findOrFail($refund_request->user_id);

        //mail send
        try {
            [$subject, $message] = $this->fetchEmailTemplate('approved_refund', ['user_name' => $user->name, 'refund_amount' => currency($request->refund_amount)]);
            $this->sendMail($user->email, $subject, $message);
        } catch (\Exception $e) {
            info($e->getMessage());
        }
        $notification = __('Refund approved successfully');
        $notification = ['message' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);

    }

    public function reject_refund_request(Request $request, $id) {
        checkAdminHasPermissionAndThrowException('refund.management');

        $request->validate([
            'admin_response' => 'required|string',
        ], [
            'admin_response.required' => __('The Note is required'),
            'admin_response.string' => __('The Note must be a string.'),
        ]);

        $refund_request = RefundRequest::findOrFail($id);
        $refund_request->status = 'rejected';
        $refund_request->admin_response = $request->admin_response;
        $refund_request->save();

        $user = User::findOrFail($refund_request->user_id);

        //mail send
        try {
            [$subject, $message] = $this->fetchEmailTemplate('reject_refund', ['user_name' => $user->name, 'order_id' => $refund_request->order_id]);
            $link = [__('Your Order') => route('user.order.details', $refund_request->order_id)];
            $this->sendMail($user->email, $subject, $message,$link);
        } catch (\Exception $e) {
            info($e->getMessage());
        }

        $notification = __('Refund rejected successfully');
        $notification = ['message' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);

    }
}
