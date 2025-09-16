<?php

namespace App\Http\Controllers\Frontend\User;

use App\Models\Admin;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use App\Traits\GlobalMailTrait;
use Modules\Order\app\Models\Order;
use App\Http\Controllers\Controller;
use Modules\Refund\app\Models\RefundRequest;
use Modules\Frontend\app\Models\ContactSection;

class RefundController extends Controller {
    use GlobalMailTrait;
    public function store(Request $request, Order $order) {
        // Validate the request
        $request->validate([
            'reason'              => 'required',
            'method'              => 'required',
            'account_information' => 'required',
        ], [
            'reason.required'              => __('Reason is required'),
            'method.required'              => __('Payment method is required'),
            'account_information.required' => __('Account information is required'),
        ]);

        // Check if the order payment status allows a refund request
        if ($order->payment_status !== OrderStatus::COMPLETED->value) {
            return back()->with(['message'    => __('You cannot send a refund request for this order.'),'alert-type' => 'error']);
        }

        // Check if a refund request already exists
        if ($order->refund) {
            return back()->with(['message'    => __('A refund request has already been sent for this order.'),'alert-type' => 'error']);
        }

        // Retrieve the authenticated user
        $authUser = userAuth();

        // Create a new refund request
        $refundRequest = RefundRequest::create([
            'user_id'             => $authUser->id,
            'order_id'            => $order->order_id,
            'reason'              => $request->reason,
            'method'              => $request->method,
            'account_information' => $request->account_information,
            'status'              => 'pending',
        ]);

        // Attempt to send an email notification
        try {
            $adminEmail = ContactSection::first()?->email ?? Admin::superAdmin()->first()?->email;
            [$subject, $message] = $this->fetchEmailTemplate('new_refund', [
                'user_name' => $authUser?->name,
            ]);
            $link = [__('See Refund Request') => route('admin.show-refund-request', $refundRequest?->id)];
            $this->sendMail($adminEmail, $subject, $message, $link);
        } catch (\Exception $e) {
            info($e->getMessage());
        }
        return back()->with(['message'    => __('Your refund request has been sent successfully.'),'alert-type' => 'success']);
    }
}
