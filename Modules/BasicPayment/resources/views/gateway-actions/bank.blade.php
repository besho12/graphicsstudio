@php
    $method = $paymentMethod;
    $bank_information = $paymentService->getGatewayDetails($method)->bank_information ?? '';
@endphp
<!DOCTYPE html>
@if (session()->get('text_direction') == 'rtl')
    <html class="no-js" lang="en" dir="rtl">
@else
    <html class="no-js" lang="en">
@endif

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Bank Checkout</title>
    <meta name="robots"
        content="{{ $setting?->search_engine_indexing === 'inactive' ? 'noindex, nofollow' : 'index, follow' }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset($setting?->favicon) }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">

</head>

<body>
    <section class="signin__area min-vh-100 my-auto d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row justify-content-center wow fadeInUp">
                <div class="col-12 mb-3 text-center">
                    <img src="{{ asset($setting?->logo) }}" alt="{{ $setting?->app_name }}">
                </div>
                <div class="col-xxl-5 col-md-9 col-lg-7 col-xl-6">
                    <div class="wsus__sign_in_form mt_80 pb_115 xs_pb_95">
                        <form class="modal-content woocommerce-checkout" action="{{ route('pay-via-bank') }}"
                            method="post">
                            @csrf
                            <div class="modal-header">
                                {!! nl2br($bank_information) !!}
                            </div>
                            <div class="modal-body">
                                <div class="form-group mb-3">
                                    <label>{{ __('Bank Name') }} *</label>
                                    <input type="text" class="form-control mb-0" placeholder="{{ __('Your bank name') }}"
                                        name="bank_name">
                                    @error('bank_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label>{{ __('Account Number') }} *</label>
                                    <input type="text" class="form-control mb-0" name="account_number"
                                        placeholder="{{ __('Your bank account number') }}">
                                    @error('account_number')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label>{{ __('Routing Number') }} </label>
                                    <input type="text" class="form-control mb-0" name="routing_number"
                                        placeholder="{{ __('Your bank routing number') }}">
                                    @error('routing_number')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label>{{ __('Branch') }} *</label>
                                    <input type="text" class="form-control mb-0" name="branch"
                                        placeholder="{{ __('Your bank branch name') }}">
                                    @error('branch')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>{{ __('Transaction') }} *</label>
                                    <input type="text" class="form-control mb-0" name="transaction"
                                        placeholder="{{ __('Provide your transaction') }}">
                                    @error('transaction')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn py-2 px-3">
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
            </div>
        </div>
    </section>
</body>

</html>