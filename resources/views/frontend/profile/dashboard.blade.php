@extends('frontend.layouts.master')

@section('meta_title', __('Dashboard') . ' || ' . $setting->app_name)

@section('header')
    @include('frontend.layouts.header-layout.three')
@endsection

@section('contents')
    <!-- Breadcumb Area -->
    <x-breadcrumb :title="__('Dashboard')" />

    <!--  Dashboard Area -->
    <section class="wsus__dashboard_profile wsus__dashboard">
        <div class="container">
            <div class="row">
                <!--  Sidebar Area -->
                @include('frontend.profile.partials.sidebar')
                <!--  Main Content Area -->
                <div class="col-lg-8 col-xl-9">
                    <div class="wsus__dashboard_main_contant">
                        <div class="row">
                            @if ($setting->is_shop == 1)
                                <div class="col-md-6 col-xl-4 mb_25">
                                    <div class="wsus__profile_overview">
                                        <p><i class="fas fa-file-invoice-dollar"></i></p>
                                        <h4>{{ $user?->orders_sum_product_qty ?? 0 }}</h4>
                                        <p class="name">{{ __('Total Purchase Item') }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-4 mb_25">
                                    <div class="wsus__profile_overview green">
                                        <p><i class="fas fa-file-invoice-dollar"></i></p>
                                        <h4>{{ currency($user?->orders_sum_amount_usd) }}</h4>
                                        <p class="name">{{ __('Total Payment') }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-4 mb_25">
                                    <div class="wsus__profile_overview orange">
                                        <p><i class="fas fa-bahai"></i></p>
                                        <h4>{{ $user?->product_reviews_count }}</h4>
                                        <p class="name">{{ __('Total Review') }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="wsus__profile_info">
                            <div class="wsus__profile_info_top">
                                <h4>{{ __('Personal Information') }}</h4>
                                <a href="{{ route('user.profile.edit') }}" class="btn">
                                    <span class="link-effect">
                                        <span class="effect-1">{{ __('Edit Info') }}</span>
                                        <span class="effect-1">{{ __('Edit Info') }}</span>
                                    </span>
                                </a>
                            </div>

                            <ul class="">
                                <li><span>{{ __('Name') }}:</span>{{ $user?->name }}</li>
                                <li><span>{{ __('Phone') }}:</span>{{ $user?->phone }}</li>
                                <li class="text-lowercase"><span>{{ __('Email') }}:</span>{{ $user?->email }}</li>
                                <li><span>{{ __('Gender') }}:</span>{{ $user?->gender }}</li>
                                <li><span>{{ __('Age') }}:</span>{{ $user?->age }}</li>
                                <li><span>{{ __('Country') }}:</span>{{ $user?->country?->name }}</li>
                                <li><span>{{ __('Province') }}:</span>{{ $user?->province }}</li>
                                <li><span>{{ __('City') }}:</span>{{ $user?->city }}</li>
                                <li><span>{{ __('Zip code') }}:</span>{{ $user?->zip_code }}</li>
                                <li><span>{{ __('Address') }}:</span>{{ $user?->address }}</li>
                            </ul>
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
