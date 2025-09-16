<?php

namespace Modules\Subscription\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubscriptionPlanRequest extends FormRequest {
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array {
        $rules = [
            'plan_name'         => 'required',
            'plan_price'        => 'required|numeric',
            'expiration_date'   => 'required',
            'serial'            => 'required',
            'status'            => 'required',
            'short_description' => 'nullable|string|max:255',
            'description'       => 'required',
            'button_text'       => 'nullable|string|max:255',
            'button_url'        => 'nullable|max:255',
        ];

        if ($this->isMethod('put')) {
            $rules['code'] = 'required|exists:languages,code';
            $rules['plan_price'] = 'sometimes|numeric';
            $rules['expiration_date'] = 'sometimes';
            $rules['serial'] = 'sometimes';
            $rules['status'] = 'sometimes';
        }
        return $rules;
    }

    function messages(): Array {
        return [
            'plan_name.required'       => __('Plan name is required'),
            'plan_price.required'      => __('Plan price is required'),

            'code.required'            => __('Language is required and must be a string.'),
            'code.exists'              => __('The selected language is invalid.'),

            'plan_price.numeric'       => __('Plan price should be numeric'),
            'expiration_date.required' => __('Expiration date is required'),
            'serial.required'          => __('Serial is required'),
            'short_description.string' => __('Short description must be a string.'),
            'short_description.max'    => __('Short description may not be greater than 255 characters.'),
            'description.required'     => __('Description is required.'),
            'button_text.nullable'     => __('The button text is not valid.'),
            'button_text.string'       => __('The button text is not valid.'),
            'button_text.max'          => __('The button text is too long.'),
            'button_url.nullable'      => __('The button url is not valid.'),
            'button_url.max'           => __('The button url is too long.'),
        ];
    }
}
