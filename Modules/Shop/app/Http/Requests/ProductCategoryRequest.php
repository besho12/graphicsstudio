<?php

namespace Modules\Shop\app\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class ProductCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::guard('admin')->check() ? true : false;
    }

    public function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:255',
        ];

        if ($this->isMethod('put')) {
            $rules['code'] = 'required|string';
        }
        if ($this->isMethod('post')) {
            $rules['slug'] = 'required|string|max:255|unique:blog_categories,slug';
        }

        return $rules;
    }

    public function messages(): array {
        return [
            'code.required'            => __('Language is required and must be a string.'),
            'code.exists'              => __('The selected language is invalid.'),
            'title.required' => __('The title is required.'),
            'title.max'      => __('Title must be string with a maximum length of 255 characters.'),
            'title.unique'   => __('Title must be unique.'),
            'slug.required'  => __('Slug is required.'),
            'slug.max'       => __('Slug must be string with a maximum length of 255 characters.'),
            'slug.unique'    => __('Slug must be unique.'),
        ];
    }
}
