<?php

namespace Modules\Order\app\Http\Controllers;

use App\Enums\RedirectType;
use App\Http\Controllers\Controller;
use App\Traits\RedirectHelperTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Modules\Language\app\Enums\TranslationModels;
use Modules\Language\app\Models\Language;
use Modules\Language\app\Traits\GenerateTranslationTrait;
use Modules\Order\app\Models\ShippingMethod;

class ShippingMethodController extends Controller {
    use GenerateTranslationTrait, RedirectHelperTrait;
    /**
     * Display a listing of the resource.
     */
    public function index() {
        checkAdminHasPermissionAndThrowException('shipping.method.view');
        $methods = ShippingMethod::with('translation')->paginate(10)->withQueryString();
        $code = request('code') ?? getSessionLanguage();
        if (!Language::where('code', $code)->exists()) {
            abort(404);
        }
        $languages = allLanguages();
        return view('order::shipping-method', compact('methods', 'languages', 'code'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse {
        checkAdminHasPermissionAndThrowException('shipping.method.management');
        $request->validate([
            'status'        => 'nullable|boolean',
            'code'          => 'required|string|exists:languages,code',
            'title'         => 'required|string|max:255',
            'fee'           => 'required|numeric',
            'is_free'       => 'nullable|boolean',
            'minimum_order' => 'required|numeric',
        ], [
            'code.required'          => __('Language is required and must be a string.'),
            'code.exists'            => __('The selected language is invalid.'),

            'code.string'            => __('The language code must be a string.'),

            'title.required'         => __('The title is required.'),
            'title.unique'           => __('Title must be unique.'),
            'title.string'           => __('Title must be string with a maximum length of 255 characters.'),
            'title.max'              => __('Title must be string with a maximum length of 255 characters.'),

            'fee.required'           => __('Shipping Cost is required and must be numeric.'),
            'fee.numeric'            => __('Shipping Cost is required and must be numeric.'),
            'minimum_order.required' => __('Minimum order is required and amount is must be numeric.'),
            'minimum_order.numeric'  => __('Minimum order is required and amount is must be numeric.'),

        ]);
        $item = ShippingMethod::create($request->all());

        $this->generateTranslations(
            TranslationModels::ShippingMethod,
            $item,
            'shipping_method_id',
            $request,
        );

        return $this->redirectWithMessage(RedirectType::CREATE->value, 'admin.shipping-method.index', ['code' => $request->code]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse {
        checkAdminHasPermissionAndThrowException('shipping.method.management');
        $request->validate([
            'status'        => 'nullable',
            'code'          => 'required|string|exists:languages,code',
            'title'         => 'required|string|max:255',
            'fee'           => 'sometimes|numeric',
            'is_free'       => 'nullable',
            'minimum_order' => 'nullable|numeric',
        ], [
            'code.required'         => __('Language is required and must be a string.'),
            'code.exists'           => __('The selected language is invalid.'),

            'code.string'           => __('The language code must be a string.'),

            'title.required'        => __('The title is required.'),
            'title.unique'          => __('Title must be unique.'),
            'title.string'          => __('Title must be string with a maximum length of 255 characters.'),
            'title.max'             => __('Title must be string with a maximum length of 255 characters.'),

            'fee.required'          => __('Shipping Cost is required and must be numeric.'),
            'fee.numeric'           => __('Shipping Cost is required and must be numeric.'),
            'minimum_order.numeric' => __('Minimum order amount is must be numeric.'),

        ]);
        $validatedData = $request->all();

        $item = ShippingMethod::findOrFail($id);
        $item->update($validatedData);

        $this->updateTranslations($item, $request, $validatedData);

        return $this->redirectWithMessage(RedirectType::UPDATE->value, 'admin.shipping-method.index', ['code' => $request->code]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        checkAdminHasPermissionAndThrowException('shipping.method.management');

        $item = ShippingMethod::findOrFail($id);

        $item->translations()->each(function ($translation) {
            $translation->shipping_method()->dissociate();
            $translation->delete();
        });

        $item->delete();

        return $this->redirectWithMessage(RedirectType::DELETE->value);
    }

    public function statusUpdate($id): JsonResponse {
        checkAdminHasPermissionAndThrowException('shipping.method.management');

        $item = ShippingMethod::find($id);

        if (request('column') == 'is_default') {
            if ($item->status == 0) {
                return response()->json([
                    'status'  => false,
                    'message' => __('You can not set an inactive method as the default method'),
                ]);
            }
            if ($item->is_default == 0) {
                ShippingMethod::where('is_default', 1)->update(['is_default' => 0]);
            }

            if (ShippingMethod::where('is_default', 1)->whereNot('id', $item->id)->count() == 0 && $item->is_default == 1) {
                ShippingMethod::where('id', 1)->update(['is_default' => 1, 'minimum_order' => 0, 'status' => 1]);
                if ($item->id != 1) {
                    $item->is_default = 0;
                }
                Session::forget('shipping_method_id');
                Session::forget('delivery_charge');
            } else {
                $item->minimum_order = 0;
                $item->is_default = $item->is_default ? 0 : 1;

                Session::forget('shipping_method_id');
                Session::forget('delivery_charge');
            }
        } elseif (request('column') == 'status') {
            if ($item->is_default == 1) {
                return response()->json([
                    'status'  => false,
                    'message' => __('You can not inactive the default method'),
                ]);
            }
            $item->status = $item->status ? 0 : 1;
        }
        $action = $item->save();

        return response()->json([
            'status'  => $action,
            'message' => $action ? __('Method Updated Successfully!') : __('Method Updating Failed!'),
        ]);
    }
}
