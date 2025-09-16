<?php

namespace App\Http\Controllers\Frontend\User;

use App\Enums\RedirectType;
use Illuminate\Http\Request;
use App\Traits\RedirectHelperTrait;
use App\Http\Controllers\Controller;
use Modules\Location\app\Models\Country;

class BillingAddressController extends Controller {
    use RedirectHelperTrait;
    public function index() {
        $addresses = userAuth()->delivery_address()->select('id','country_id','title', 'first_name', 'last_name', 'email', 'phone', 'province', 'city', 'address', 'zip_code')->latest()->paginate(5);

        $countries = Country::select('id')->with(['translation' => function ($query) {
            $query->select('country_id', 'name');
        }])->active()->orderBy('slug')->get();

        return view('frontend.profile.billing_address', compact('addresses','countries'));
    }
    public function store(Request $request) {
        $validated = $this->requestValidation($request);
        userAuth()->delivery_address()->create($validated);
        return $this->redirectWithMessage(RedirectType::CREATE->value, 'user.billing.index');
    }
    public function update(Request $request,$id) {
        $address = userAuth()->delivery_address()->where('id', $id)->firstOrFail();
        $validated = $this->requestValidation($request);
        $address->update($validated);
        return $this->redirectWithMessage(RedirectType::UPDATE->value, 'user.billing.index');
    }
    public function destroy($id) {
        $address = userAuth()->delivery_address()->where('id', $id)->firstOrFail();
        $address->delete();
        return $this->redirectWithMessage(RedirectType::DELETE->value, 'user.billing.index');
    }

    private function requestValidation($request) {
        return $request->validate([
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
    }
}
