@extends('frontend.layouts.master')

@section('meta_title', $seo_setting['pricing_page']['seo_title'])
@section('meta_description', $seo_setting['pricing_page']['seo_description'])

@section('header')
    @include('frontend.layouts.header-layout.three')
@endsection

@section('contents')
    <!-- Breadcumb Area -->
    <x-breadcrumb :image="$setting?->pricing_page_breadcrumb_image" :title="__('Pricing')" />

    <!-- Main Area -->
    <div class="space">
        <div class="container">
            <div class="row gy-4 justify-content-center">
                @forelse ($plans as $plan)
                    <div class="col-lg-4 col-md-6">
                        <div class="pricing-card bg-smoke">
                            <h4 class="pricing-card_title">{{ $plan?->plan_name }}</h4>
                            <div class="price-card-wrap">
                                <h4 class="pricing-card_price"><span
                                        class="currency">{{ currency($plan?->plan_price) }}</span><span
                                        class="duration">/{{ $plan?->expiration_date }}</span>
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
            @if ($plans->hasPages())
                <div class="btn-wrap justify-content-center mt-60">
                    {{ $plans->onEachSide(0)->links('frontend.pagination.custom') }}
                </div>
            @endif
        </div>
    </div>

    <!--==============================
        Faq Area
        ==============================-->
    <div class="faq-area-2 space-bottom overflow-hidden">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8">
                    <div class="accordion-area accordion" id="faqAccordion">
                        @foreach ($faqs as $index => $faq)
                            <div class="accordion-card style2 {{ $index == 0 ? 'active' : '' }}">
                                <div class="accordion-header" id="collapse-item-{{ $index + 1 }}">
                                    <button class="accordion-button {{ $index == 0 ? '' : 'collapsed' }}" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapse-{{ $index + 1 }}"
                                        aria-expanded="{{ $index == 0 ? 'true' : 'false' }}"
                                        aria-controls="collapse-{{ $index + 1 }}">{{ $faq?->question }}</button>
                                </div>
                                <div id="collapse-{{ $index + 1 }}"
                                    class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}"
                                    aria-labelledby="collapse-item-{{ $index + 1 }}" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        <p class="faq-text">{{ $faq?->answer }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--  Marquee Area -->
    @include('frontend.partials.marquee')
@endsection
@section('footer')
    @include('frontend.layouts.footer-layout.two')
@endsection
