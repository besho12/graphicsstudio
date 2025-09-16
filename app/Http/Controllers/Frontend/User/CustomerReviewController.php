<?php

namespace App\Http\Controllers\Frontend\User;

use Illuminate\Http\Request;
use App\Rules\CustomRecaptcha;
use App\Http\Controllers\Controller;
use Modules\Shop\app\Models\Product;
use Modules\Shop\app\Models\ProductReview;
use Modules\GlobalSetting\app\Models\Setting;
use Modules\GlobalSetting\app\Models\CustomPagination;

class CustomerReviewController extends Controller {
    public function index() {
        $reviews = ProductReview::select('id', 'product_id', 'user_id', 'name', 'review', 'rating', 'created_at')->with(['product' => function ($query) {
            $query->select('id', 'slug');
        }, 'user' => function ($query) {
            $query->select('id', 'image');
        }])->where('user_id', userAuth()->id)->orderBy('id', 'desc');

        $review_per_age = cache('CustomPagination')?->customer_reviews ?? CustomPagination::where('section_name', 'Customer Reviews')->value('item_qty');

        $reviews = $reviews->paginate($review_per_age)->withQueryString();

        return view('frontend.profile.reviews', compact('reviews'));
    }
    public function store(Request $request) {
        $setting = cache()->get('setting');
        $request->validate([
            'slug'                 => 'required',
            'review'               => 'required',
            'rating'               => 'required|numeric|between:1,5',
            'g-recaptcha-response' => $setting?->recaptcha_status == 'active' ? ['required', new CustomRecaptcha()] : '',
        ], [
            'slug.required'                 => __('Slug is required.'),
            'review.required'               => __('Review is required'),
            'rating.required'               => __('Rating is required'),
            'g-recaptcha-response.required' => __('Please complete the recaptcha to submit the form'),
        ]);
        $user = userAuth();
        $product = Product::whereSlug($request->slug)->first();
        if (ProductReview::where(['user_id' => $user->id, 'product_id' => $product?->id])->exists()) {
            $notification = __('You already submit a review');
            $notification = ['message' => $notification, 'alert-type' => 'error'];

            return redirect()->back()->with($notification);
        }

        $approved_status = cache('setting')?->review_auto_approved ?? Setting::where('key', 'review_auto_approved')->select('value')->first()->value;

        $data = new ProductReview();
        $data->user_id = $user->id;
        $data->product_id = $product?->id;
        $data->name = $user?->name;
        $data->email = $user?->email;
        $data->review = $request->review;
        $data->rating = $request->rating;

        if ($approved_status == 'active') {
            $data->status = true;
            $notification = __('Review Added Successfully');
            $notification = ['message' => $notification, 'alert-type' => 'success'];
        } else {
            $notification = __('Review Added, wait for admin approval');
            $notification = ['message' => $notification, 'alert-type' => 'info'];
        }
        $data->save();

        return redirect()->back()->with($notification);
    }
}
