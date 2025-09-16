@extends('frontend.layouts.master')

@section('meta_title', __('Buy Now'))
@push('custom_meta')
    <meta property="og:title" content="{{ __('Buy Now') }}" />
    <meta property="og:description" content="{{ __('Buy Now') }}" />
    <meta property="og:image" content="{{ asset($setting?->checkout_page_breadcrumb_image) }}" />
    <meta property="og:URL" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
@endpush

@section('header')
    @include('frontend.layouts.header-layout.three')
@endsection
@use('Modules\Shop\app\Models\DeliveryAddress')

@section('contents')
    <!-- Breadcumb -->
    <x-breadcrumb :image="$setting?->checkout_page_breadcrumb_image" :title="__('Buy Now')" />

    <!-- Main Area -->
    <div class="checkout-wrapper space-top space-extra-bottom">
        <div class="container">
            <div class="woocommerce-checkout">
                <form class="row checkout_tabs gx-60 gy-60" id="place-order-form">
                    <div class="col-lg-6">
                        <label>{{ __('Billing Address') }} *</label>
                        <div class="input-group mb-3">
                            <select class="form-select billing-address-select" name="billing_address" id="billing_address">
                                <option value="">{{ __('Select Address') }}</option>
                                @foreach ($delivery_addresses as $index => $delivery)
                                    <option @selected(old('billing_address') == $delivery->id || $loop->first == 1) value="{{ $delivery->id }}">{{ $delivery->title }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <a class="btn style2 wc-forward py-3" href="javascript:;" data-bs-toggle="modal"
                                    data-bs-target="#delivery-address-modal"><i data-bs-toggle="tooltip"
                                        data-placement="top" title="{{ __('Billing Address') }}" class="fas fa-plus"></i>
                                    {{ __('Add New') }}</a>
                            </div>
                        </div>

                        <div class="form-check ps-0 mb-4">
                            <input class="form-check-input mt-2" name="same_as_shipping" type="checkbox"
                                id="checkBillingAsShipping" checked>
                            <label class="form-check-label" for="checkBillingAsShipping">
                                {{ __('Same as shipping address') }}
                            </label>
                        </div>
                        <div class="row d-none" id="shipping-address-form">
                            <h4>{{ __('Shipping Address') }}</h4>
                            <div class="col-md-6 form-group">
                                <label>{{ __('First Name') }} *</label>
                                <input type="text" class="form-control" placeholder="{{ __('First Name') }}"
                                    value="{{ old('shipping_first_name') }}" name="shipping_first_name">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>{{ __('Last Name') }}</label>
                                <input type="text" class="form-control" placeholder="{{ __('Last Name') }}"
                                    name="shipping_last_name" value="{{ old('shipping_last_name') }}">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>{{ __('Phone') }} *</label>
                                <input type="text" class="form-control" placeholder="{{ __('Phone') }}"
                                    name="shipping_phone" value="{{ old('shipping_phone') }}">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>{{ __('Email Address') }} *</label>
                                <input type="email" class="form-control" placeholder="{{ __('Email') }}"
                                    name="shipping_email" value="{{ old('shipping_email') }}">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>{{ __('Country') }} *</label>
                                <select class="form-select" name="shipping_country" id="shipping_country">
                                    @foreach ($countries as $country)
                                        <option @selected(old('shipping_country') == $country?->id) value="{{ $country?->name }}">
                                            {{ $country?->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>{{ __('Province') }} *</label>
                                <input type="text" class="form-control" name="shipping_province"
                                    placeholder="{{ __('Province') }}" value="{{ old('shipping_province') }}">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>{{ __('City') }} *</label>
                                <input type="text" class="form-control" name="shipping_city"
                                    placeholder="{{ __('City') }}" value="{{ old('shipping_city') }}">

                            </div>
                            <div class="col-md-6 form-group">
                                <label>{{ __('Zip code') }} *</label>
                                <input type="text" class="form-control" placeholder="{{ __('Zip code') }}"
                                    name="shipping_zip_code" value="{{ old('shipping_zip_code') }}">
                            </div>
                            <div class="col-md-12 form-group">
                                <label>{{ __('Address') }} <span>*</span></label>
                                <input type="text" class="form-control" placeholder="{{ __('Address') }}"
                                    name="shipping_address" value="{{ old('shipping_address') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div id="show_currency_notifications">
                                <div class="alert alert-warning mt-2 d-none"></div>
                            </div>
                            <div class="checkout_payment d-flex flex-wrap gap-3">
                                @foreach ($activeGateways as $gatewayKey => $gatewayDetails)
                                    @if (!$applyDeliveryCharge && $gatewayKey == 'hand_cash')
                                        @continue
                                    @endif
                                    <a class="place-order-btn"
                                        data-url="{{ route('place.order', ['method' => $gatewayKey, 'buyNow' => $product?->slug, 'qty' => $qty]) }}">
                                        <img class="shadow-sm p-2 payment-logo" src="{{ asset($gatewayDetails['logo']) }}"
                                            alt="{{ $gatewayDetails['name'] }}">
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="checkout_summery">
                            <h5 class="fw-semibold mb-35">{{ __('Your Order') }}</h5>
                            @if ($setting?->is_delivery_charge && $applyDeliveryCharge)
                                <div class="row gx-60 gy-60">
                                    <div class="woocommerce-checkout col-lg-6 form-group">
                                        <label class="text-start">{{ __('Shipping Type') }}</label>
                                        <select class="form-select" name="shipping_method" id="buy_now_shipping_method">
                                            @foreach ($shippingMethods as $method)
                                                @if ($method->minimum_order <= totalAmount($total_price)?->total)
                                                    <option @selected($method->id == session('shipping_method_id', 0))
                                                        value="{{ route('user.update.buy.now.shipping-method', ['id' => $method->id, 'slug' => $product->slug, 'qty' => $qty]) }}">
                                                        {{ $method->title }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif
                            <div class="woocommerce-cart-form checkout-summary-content">
                                @include('frontend.pages.shop.partials.buy-now-summary')
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--  Billing address add form modal -->
    <div class="modal fade" id="delivery-address-modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered custom-max-width">
            <form id="add-billing-address-form" class="modal-content woocommerce-checkout"
                action="{{ route('user.store.billing') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h4>{{ __('Billing Address') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>{{ __('First Name') }} *</label>
                            <input type="text" class="form-control" placeholder="{{ __('First Name') }}"
                                value="{{ old('first_name') }}" name="first_name">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{ __('Last Name') }}</label>
                            <input type="text" class="form-control" placeholder="{{ __('Last Name') }}"
                                name="last_name" value="{{ old('last_name') }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{ __('Phone') }} *</label>
                            <input type="text" class="form-control" placeholder="{{ __('Phone') }}" name="phone"
                                value="{{ old('phone') }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{ __('Email Address') }} *</label>
                            <input type="email" class="form-control" placeholder="{{ __('Email') }}" name="email"
                                value="{{ old('email') }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{ __('Title') }} *</label>
                            <input type="text" class="form-control" placeholder="{{ __('Title') }}" name="title"
                                value="{{ old('title') }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{ __('Country') }} *</label>
                            <select class="form-select" name="country_id" id="country_id">
                                @foreach ($countries as $country)
                                    <option @selected(old('country_id') == $country?->id) value="{{ $country?->id }}">
                                        {{ $country?->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{ __('Province') }} *</label>
                            <input type="text" class="form-control" name="province"
                                placeholder="{{ __('Province') }}" value="{{ old('province') }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{ __('City') }} *</label>
                            <input type="text" class="form-control" name="city" placeholder="{{ __('City') }}"
                                value="{{ old('city') }}">

                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{ __('Zip code') }} *</label>
                            <input type="text" class="form-control" placeholder="{{ __('Zip code') }}"
                                name="zip_code" value="{{ old('zip_code') }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{ __('Address') }} <span>*</span></label>
                            <input type="text" class="form-control" placeholder="{{ __('Address') }}" name="address"
                                value="{{ old('address') }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn py-2 px-3" data-bs-dismiss="modal">
                        <span class="link-effect text-uppercase">
                            <span class="effect-1">{{ __('Close') }}</span>
                            <span class="effect-1">{{ __('Close') }}</span>
                        </span>
                    </button>
                    <button type="submit" class="btn style2 py-2 px-3">
                        <span class="link-effect text-uppercase">
                            <span class="effect-1">{{ __('Submit') }}</span>
                            <span class="effect-1">{{ __('Submit') }}</span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>


    <!--  Marquee Area -->
    @include('frontend.partials.marquee')
@endsection

@section('footer')
    @include('frontend.layouts.footer-layout.two')
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $(document).on("submit", "#add-billing-address-form", function(e) {
                e.preventDefault();
                const form = $("#add-billing-address-form");
                const formData = form.serialize();

                $.ajax({
                    url: form.attr("action"),
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    beforeSend: function() {
                        showPreLoader();
                    },
                    success: (response) => {
                        if (response.success) {
                            form.find("input, textarea").val("");
                            form.find("select").prop("selectedIndex", 0);
                            $("#delivery-address-modal").modal("hide");
                            $("#billing_address option:selected").prop("selected", false);
                            $("#billing_address").append(response.html);
                        } else {
                            toastr.warning(response.message);
                        }
                    },
                    error: (error) => {
                        if (error.status == 422) {
                            $.each(
                                error.responseJSON?.message,
                                function(key, message) {
                                    toastr.error(message);
                                }
                            );
                        } else {
                            toastr.error(
                                error.responseJSON?.message || basic_error_message
                            );
                        }
                    },
                    complete: hidePreLoader,
                });
            });

            //check billing address as shipping address
            $("#checkBillingAsShipping").change(function() {
                $("#shipping-address-form").toggleClass("d-none", this.checked);
            });

            //update shipping method
            $(document).on("change", "#buy_now_shipping_method", function() {
                var url = $(this).val();
                $.ajax({
                    url: url,
                    type: "POST",
                    dataType: "json",
                    beforeSend: function() {
                        showPreLoader();
                    },
                    success: function(response) {
                        if (response.success) {
                            $(
                                ".woocommerce-cart-form.checkout-summary-content"
                            ).html(response.checkoutSummary);
                            toastr.success(response.message);
                        } else {
                            toastr.info(response.message);
                        }
                    },
                    error: (data) => {
                        toastr.error(
                            data.responseJSON?.message || basic_error_message
                        );
                    },
                    complete: hidePreLoader,
                });
            });

            //place order
            $(document).on("click", ".place-order-btn", function(e) {
                e.preventDefault();
                const url = $(this).data("url");
                const form = $("#place-order-form");
                const formData = form.serialize();

                $.ajax({
                    url: url,
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    beforeSend: function() {
                        $("#show_currency_notifications .alert-warning").addClass(
                            "d-none"
                        );
                        showPreLoader();
                    },
                    success: (response) => {
                        if (response.success) {
                            window.location.href =
                                `${base_url}/payment?order_id=${response.order_id}`;
                        } else {
                            if (response.supportCurrency) {
                                $("#show_currency_notifications .alert-warning").html(response
                                    .supportCurrency).removeClass("d-none");
                            }
                            toastr.warning(response.message);
                            hidePreLoader();
                        }
                    },
                    error: (error) => {
                        if (error.status == 422) {
                            $.each(
                                error.responseJSON?.message,
                                function(key, message) {
                                    toastr.error(message);
                                }
                            );
                        } else {
                            toastr.error(
                                error.responseJSON?.message || basic_error_message
                            );
                        }
                        hidePreLoader();
                    },
                });
            });
        });
    </script>
@endpush
