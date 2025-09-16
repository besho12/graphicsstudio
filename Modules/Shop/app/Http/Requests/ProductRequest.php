<?php

namespace Modules\Shop\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Modules\Shop\app\Models\Product;

class ProductRequest extends FormRequest {
    public function authorize(): bool {
        return Auth::guard('admin')->check() ? true : false;
    }

    public function rules(): array {
        $rules = [
            'seo_title'              => 'nullable|string|max:1000',
            'seo_description'        => 'nullable|string|max:1000',
            'tags'                   => 'nullable|string|max:255',
            'is_popular'             => 'nullable',
            'is_new'                 => 'nullable',
            'status'                 => 'nullable',
            'description'            => 'required',
            'short_description'      => 'nullable|string|max:500',
            'additional_description' => 'nullable',
        ];

        if ($this->isMethod('put')) {
            $rules['code'] = 'required|exists:languages,code';
            $rules['title'] = 'required|string|max:255';
            $rules['sku'] = 'required|string|max:255|unique:products,sku,' . $this->product;
            $rules['product_category_id'] = 'required|exists:product_categories,id';
            $rules['price'] = 'required|numeric';
            $rules['sale_price'] = 'nullable|numeric|lt:price';
            $rules['image'] = 'nullable|mimetypes:image/jpeg,image/png,image/gif,image/webp,image/svg+xml';

            if ($this->type == Product::DIGITAL_TYPE) {
                $rules['file_path'] = 'required|string';
            }else{
                $rules['qty'] = 'required';
            }

        }
        if ($this->isMethod('post')) {
            $rules['image'] = 'required|mimetypes:image/jpeg,image/png,image/gif,image/webp,image/svg+xml';
            $rules['slug'] = 'required|string|max:255|unique:products,slug';
            $rules['title'] = 'required|string|max:255|unique:product_translations,title';
            $rules['sku'] = 'required|string|max:255|unique:products,sku';
            $rules['price'] = 'required|numeric';
            $rules['sale_price'] = 'nullable|numeric|lt:price';
            $rules['product_category_id'] = 'required|exists:product_categories,id';

            if ($this->type == Product::DIGITAL_TYPE) {
                $rules['type'] = 'required|in:' . implode(',', array_keys(Product::getTypes()));
                $rules['file_path'] = 'required|string';
            }else{
                $rules['qty'] = 'required';
            }
        }
        return $rules;

    }

    public function messages(): array {
        return [
            'product_category_id.required' => __('The category is required.'),
            'product_category_id.exists'   => __('The selected category is invalid.'),

            'code.required'                => __('Language is required and must be a string.'),
            'code.exists'                  => __('The selected language is invalid.'),

            'tags.max'                     => __('Tags may not be greater than 255 characters.'),
            'tags.string'                  => __('Tags must be a string.'),

            'image.required'               => __('Image is required'),
            'image.image'                  => __('The image must be an image.'),
            'image.max'                    => __('The image may not be greater than 2048 kilobytes.'),

            'sku.required'                 => __('SKU is required.'),
            'sku.max'                      => __('SKU may not be greater than 255 characters.'),

            'sku.string'                   => __('SKU must be a string.'),
            'sku.unique'                   => __('SKU must be unique.'),

            'qty.required'                 => __('Quantity is required.'),
            'description.required'         => __('Description is required.'),
            'short_description.required'   => __('Short description is required.'),
            'short_description.string'     => __('Short description must be a string.'),
            'short_description.max'        => __('Short may not be greater than 500 characters.'),

            'price.required'               => __('Regular Price is required and must be a numeric.'),
            'price.numeric'                => __('Regular Price is required and must be a numeric.'),
            'sale_price.numeric'           => __('Sale Price is required and must be a numeric.'),
            'sale_price.lt'                => __('The Sale Price must be less than the regular price.'),

            'slug.required'                => __('Slug is required.'),
            'slug.string'                  => __('The slug must be a string.'),
            'slug.max'                     => __('The slug may not be greater than 255 characters.'),
            'slug.unique'                  => __('The slug has already been taken.'),

            'title.required'               => __('The title is required.'),
            'title.string'                 => __('The title must be a string.'),
            'title.max'                    => __('The title may not be greater than 255 characters.'),
            'title.unique'                 => __('Title must be unique.'),

            'seo_title.max'                => __('SEO title may not be greater than 1000 characters.'),
            'seo_title.string'             => __('SEO title must be a string.'),
            'seo_description.max'          => __('SEO description may not be greater than 2000 characters.'),
            'seo_description.string'       => __('SEO description must be a string.'),

            'type.required'                => __('Product Type is required.'),
            'type.in'                      => __('Invalid Product Type'),
            'file_path.required'           => __('Product File is required.'),
            'file_path.string'             => __('Product File is must be a string.'),
        ];
    }
}
