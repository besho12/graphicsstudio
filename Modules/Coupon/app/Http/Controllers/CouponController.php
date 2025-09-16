<?php

namespace Modules\Coupon\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Coupon\app\Models\Coupon;
use Modules\Coupon\app\Models\CouponHistory;

class CouponController extends Controller {
    public function index() {
        checkAdminHasPermissionAndThrowException('coupon.management');
        $coupons = Coupon::where(['author_id' => 0])->latest()->get();

        return view('coupon::index', compact('coupons'));
    }

    public function store(Request $request) {
        checkAdminHasPermissionAndThrowException('coupon.management');
        $rules = [
            'coupon_code'  => 'required|unique:coupons',
            'discount'     => 'required|numeric',
            'min_price'    => 'required|numeric',
            'start_date'   => 'required|date|before:expired_date',
            'expired_date' => 'required|date|after:start_date',
            'discount_type' => 'required|in:percentage,amount',
        ];
        $customMessages = [
            'coupon_code.required'  => __('Coupon code is required'),
            'coupon_code.unique'    => __('Coupon already exist'),
            'discount.required'     => __('Discount is required'),
            'start_date.required'   => __('Start date is required'),
            'start_date.before'     => __('Start date must be before the expired date'),
            'expired_date.required' => __('Expired date is required'),
            'expired_date.after'    => __('Expired date must be after the start date'),
            'min_price.required'    => __('Minimum price is required'),
            'discount_type.required' => __('Discount type is required'),
            'discount_type.in'      => __('Discount type must be either percentage or amount'),
        ];

        $this->validate($request, $rules, $customMessages);

        $coupon = new Coupon();
        $coupon->author_id = 0;
        $coupon->coupon_code = $request->coupon_code;
        $coupon->discount = $request->discount;
        $coupon->min_price = $request->min_price;
        $coupon->start_date = $request->start_date;
        $coupon->expired_date = $request->expired_date;
        $coupon->discount_type = $request->discount_type;
        $coupon->status = $request->status;
        $coupon->save();

        $notification = __('Created Successfully');
        $notification = ['message' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);

    }

    public function update(Request $request, $id) {
        checkAdminHasPermissionAndThrowException('coupon.management');
        $rules = [
            'coupon_code'  => 'required|unique:coupons,coupon_code,' . $id,
            'discount'     => 'required|numeric',
            'min_price'    => 'required|numeric',
            'start_date'   => 'required|date|before:expired_date',
            'expired_date' => 'required|date|after:start_date',
            'discount_type' => 'required|in:percentage,amount',
        ];
        $customMessages = [
            'coupon_code.required'  => __('Coupon code is required'),
            'coupon_code.unique'    => __('Coupon already exist'),
            'discount.required'     => __('Discount is required'),
            'start_date.required'   => __('Start date is required'),
            'start_date.before'     => __('Start date must be before the expired date'),
            'expired_date.required' => __('Expired date is required'),
            'expired_date.after'    => __('Expired date must be after the start date'),
            'min_price.required'    => __('Minimum price is required'),
            'discount_type.required' => __('Discount type is required'),
            'discount_type.in'      => __('Discount type must be either percentage or amount'),
        ];

        $this->validate($request, $rules, $customMessages);

        $coupon = Coupon::find($id);
        $coupon->coupon_code = $request->coupon_code;
        $coupon->discount = $request->discount;
        $coupon->min_price = $request->min_price;
        $coupon->start_date = $request->start_date;
        $coupon->expired_date = $request->expired_date;
        $coupon->discount_type = $request->discount_type;
        $coupon->status = $request->status;
        $coupon->save();

        $notification = __('Updated Successfully');
        $notification = ['message' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);

    }

    public function destroy($id) {
        checkAdminHasPermissionAndThrowException('coupon.management');
        $coupon = Coupon::find($id);
        $coupon->delete();

        $notification = __('Deleted Successfully');
        $notification = ['message' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);

    }

    public function coupon_history() {
        checkAdminHasPermissionAndThrowException('coupon.management');

        $coupon_histories = CouponHistory::where(['author_id' => 0])->latest()->get();

        return view('coupon::history', ['coupon_histories' => $coupon_histories]);
    }
    public function statusUpdate($id) {
        checkAdminHasPermissionAndThrowException('coupon.management');

        $coupon = Coupon::find($id);
        $status = $coupon->status == 'active' ? 'inactive' : 'active';
        $coupon->update(['status' => $status]);

        $notification = __('Updated Successfully');

        return response()->json([
            'success' => true,
            'message' => $notification,
        ]);
    }
}
