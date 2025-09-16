@extends('frontend.layouts.master')

@section('meta_title', __('Order Completed') . ' || ' . $setting->app_name)

@section('header')
    @include('frontend.layouts.header-layout.three')
@endsection

@section('contents')
<section class="signin__area min-vh-100 my-auto d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="row justify-content-center wow fadeInUp">
            <div class="col-xxl-5 col-md-9 col-lg-7 col-xl-6">
                <div class="wsus__sign_in_form mt_80 pb_115 xs_pb_95 border-0 shadow-none">
                    <div class="text-center">
                        <img src="{{ asset('uploads/website-images/success.png') }}" alt="{{__('Order Completed')}}">
                        <h6 class="mt-2">{{ __('Your order has been placed') }}</h6>
                        <p>{{ __('For check more details you can go to your dashboard') }}</p>
                        <a href="{{ route('dashboard') }}" class="btn style2">
                            <span class="link-effect text-uppercase">
                                <span class="effect-1">{{ __('Go to Dashboard') }}</span>
                                <span class="effect-1">{{ __('Go to Dashboard') }}</span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!--  Marquee Area -->
    @include('frontend.partials.marquee')
@endsection
@section('footer')
    @include('frontend.layouts.footer-layout.two')
@endsection
