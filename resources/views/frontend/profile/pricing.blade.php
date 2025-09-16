@extends('frontend.layouts.master')

@section('meta_title', __('Pricing') . ' || ' . $setting->app_name)

@section('header')
    @include('frontend.layouts.header-layout.three')
@endsection

@section('contents')
    <!-- Breadcumb Area -->
    <x-breadcrumb :title="__('Pricing')" />

    <!--  Dashboard Area -->
    <section class="wsus__dashboard_profile wsus__dashboard">
        <div class="container">
            <div class="row">
                <!--  Sidebar Area -->
                @include('frontend.profile.partials.sidebar')
                <!--  Main Content Area -->
                <div class="col-lg-8 col-xl-9">
                    <div class="wsus__dashboard_main_contant wsus__dashboard_pricing">
                        <div class="row">
                            @forelse ($plans as $plan)
                                <div class="col-md-6 mb-4">
                                    <div class="pricing-card bg-smoke">
                                        <h4 class="pricing-card_title">{{ $plan?->plan_name }}</h4>
                                        <div class="price-card-wrap">
                                            <h4 class="pricing-card_price"><span class="currency">{{ currency($plan?->plan_price) }}</span><span class="duration">/{{ $plan?->expiration_date }}</span>
                                            </h4>
                                        </div>
                                        <p>{{ $plan?->short_description }}</p>
                                        <div class="checklist">
                                            {!! clean($plan?->description) !!}
                                        </div>
                                        @if ($plan?->button_text)
                                            <a href="{{ $plan?->button_url }}" class="btn">
                                                <span class="link-effect text-uppercase">
                                                    <span class="effect-1">{{ $plan?->button_text }}</span>
                                                    <span class="effect-1">{{ $plan?->button_text }}</span>
                                                </span>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <x-data-not-found />
                                </tr>
                            @endforelse
                        </div>
                    </div>
                    @if ($plans->hasPages())
                        {{ $plans->onEachSide(0)->links('frontend.pagination.custom') }}
                    @endif
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
