@extends('frontend.layouts.master')

@section('meta_title', $service?->seo_title . ' || ' . $setting->app_name)
@section('meta_description', $service?->seo_description)

@push('custom_meta')
    <meta property="og:title" content="{{ $service?->seo_title }}" />
    <meta property="og:description" content="{{ $service?->seo_description }}" />
    <meta property="og:image" content="{{ asset($service?->image) }}" />
    <meta property="og:URL" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
@endpush

@section('header')
    @include('frontend.layouts.header-layout.three')
@endsection

@section('contents')
    <!-- breadcrumb-area -->
    <x-breadcrumb-two :title="$service?->title" :links="[['url' => route('home'), 'text' => __('Home')],['url' => route('services'), 'text' => __('Service')]]" />

    <!-- Main Area -->
    <div class="service-details-page-area space">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-xl-12">
                    <div class="service-inner-thumb mb-80 wow img-custom-anim-top">
                        <img class="w-100" src="{{ asset($service?->image) }}" alt="{{ $service?->title }}">
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="title-area details-text mb-35">
                        <h2>{{ $service?->title }}</h2>
                        {!! clean(replaceImageSources($service?->description)) !!}
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="row">
                        <h3 class="mt-5 mb-5">Service Projects</h3>
                        @forelse ($service->projects as $index => $project)
                            <div class="col-lg-6 filter-item">
                                <div class="portfolio-wrap {{ $index == 0 ? 'mt-lg-140' : ($index == 1 ? 'mt-lg-0' : '') }}" style="margin-top: 100px;">
                                    <div class="portfolio-thumb wow img-custom-anim-top" data-wow-duration="1.5s"
                                        data-wow-delay="0.2s">
                                        <a href="{{ route('single.portfolio', $project?->slug) }}">
                                            <img src="{{ asset($project?->image) }}" alt="{{ $project?->title }}">
                                        </a>
                                    </div>
                                    <div class="portfolio-details">
                                        <ul class="portfolio-meta">
                                            <li><a href="javascript:;">{{ $project?->project_category }}</a></li>
                                        </ul>
                                        <h3 class="portfolio-title"><a
                                                href="{{ route('single.portfolio', $project?->slug) }}">{{ $project?->title }}</a>
                                        </h3>
                                        <a href="{{ route('single.portfolio', $project?->slug) }}" class="link-btn">
                                            <span class="link-effect">
                                                <span class="effect-1">{{ __('View Project') }}</span>
                                                <span class="effect-1">{{ __('View Project') }}</span>
                                            </span>
                                            <img src="{{ asset('frontend/images/arrow-left-top.svg') }}" alt="icon">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <x-data-not-found />
                        @endforelse
                    </div>
                </div>


                <br>

                <div class="col-xl-12 mt-5">
                    <!-- Contact Area -->
                    <div class="contact-area-1 space bg-theme">
                        <div class="contact-map shape-mockup wow img-custom-anim-left" data-wow-duration="1.5s" data-wow-delay="0.2s"
                            data-left="0" data-top="-100px" data-bottom="140px">
                            <iframe src="{{ $contactSection?->map }}" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                        <div class="container">
                            <div class="row align-items-center justify-content-end">
                                <div class="col-lg-6">
                                    <div class="contact-form-wrap">
                                        <div class="title-area mb-30">
                                            <h2 class="sec-title">{{ __('Have Any Project on Your Mind?') }}</h2>
                                            <p>{{ __("Great! We're excited to hear from you and let's start something") }}</p>
                                        </div>
                                        <form action="{{ route('send-contact-message') }}" id="contact-form" class="contact-form">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control style-border" name="name"
                                                            placeholder="{{ __('Full name') }}*" value="{{ old('name') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="email" class="form-control style-border" name="email"
                                                            placeholder="{{ __('Email address') }}*" value="{{ old('email') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control style-border" name="website"
                                                            placeholder="{{ __('Website link') }}" value="{{ old('website') }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control style-border" name="subject"
                                                            value="{{ $service?->title }} - Service" placeholder="{{ __('Subject') }}*" value="{{ old('subject') }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <textarea name="message" placeholder="{{ __('How Can We Help You') }}*" class="form-control style-border" required>{{ old('message') }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($setting?->recaptcha_status == 'active')
                                                <div class="form-group mb-0 col-12">
                                                    <div class="g-recaptcha" data-sitekey="{{ $setting?->recaptcha_site_key }}"></div>
                                                </div>
                                            @endif
                                            <div class="form-btn col-12">
                                                <button type="submit" class="btn mt-20">
                                                    <span class="link-effect text-uppercase">
                                                        <span class="effect-1">{{ __('Send message') }}</span>
                                                        <span class="effect-1">{{ __('Send message') }}</span>
                                                    </span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
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
