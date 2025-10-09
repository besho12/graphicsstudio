<?php

namespace Modules\Frontend\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandsSectionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title'              => ['required', 'string', 'max:255'],
            'sub_title'          => ['nullable', 'string', 'max:1000'],
        ];
    }

    function messages(): array
    {
        return [
            'title.required'            => __('The title is required'),
            'title.string'              => __('The title must be a string'),
            'title.max'                 => __('The title must not be more than 255 characters'),

            'sub_title.string'          => __('The sub title must be a string'),
            'sub_title.max'             => __('The sub title must not be more than 1000 characters'),
        ];
    }
}