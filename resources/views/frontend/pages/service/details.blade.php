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

    <!-- Service Details Hero Section -->
    <div class="service-details-hero space-top">
        <div class="container-fluid px-0">
            <div class="service-hero-modern-wrapper">
                <div class="row g-0 min-vh-100 align-items-center">
                    <!-- Left Content Section -->
                    <div class="col-lg-6 col-xl-7">
                        <div class="service-hero-content-section">
                            <div class="container">
                                <div class="service-hero-text-content">
                                    <div class="service-hero-badge-modern">
                                        <i class="fas fa-star"></i>
                                        <span>{{ __('Premium Service') }}</span>
                                    </div>
                                    <h1 class="service-hero-title">{{ $service?->title }}</h1>
                                    <p class="service-hero-description">
                                        {{ Str::limit(strip_tags($service?->description), 200) }}
                                    </p>
                                    <div class="service-hero-meta">
                                        <div class="service-meta-item">
                                            <i class="fas fa-clock"></i>
                                            <span>{{ __('Fast Delivery') }}</span>
                                        </div>
                                        <div class="service-meta-item">
                                            <i class="fas fa-shield-alt"></i>
                                            <span>{{ __('Quality Guaranteed') }}</span>
                                        </div>
                                        <div class="service-meta-item">
                                            <i class="fas fa-headset"></i>
                                            <span>{{ __('24/7 Support') }}</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Stats Section -->
                                    <div class="service-hero-stats-inline">
                                        <div class="stat-item-inline">
                                            <div class="stat-number">5.0</div>
                                            <div class="stat-label">{{ __('Rating') }}</div>
                                            <div class="stat-stars">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                        </div>
                                        <div class="stat-item-inline">
                                            <div class="stat-number">500+</div>
                                            <div class="stat-label">{{ __('Projects') }}</div>
                                        </div>
                                        <div class="stat-item-inline">
                                            <div class="stat-number">98%</div>
                                            <div class="stat-label">{{ __('Satisfaction') }}</div>
                                        </div>
                                    </div>
                                    
                                    <div class="service-hero-actions">
                                        <a href="#service-content" class="btn btn-primary btn-modern">
                                            {{ __('Learn More') }}
                                            <i class="fas fa-arrow-down ms-2"></i>
                                        </a>
                                        <a href="#contact" class="btn btn-outline-primary btn-modern">
                                            {{ __('Get Quote') }}
                                            <i class="fas fa-paper-plane ms-2"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Image Section -->
                    <div class="col-lg-6 col-xl-5">
                        <div class="service-hero-image-section">
                            <div class="service-hero-image-wrapper">
                                <div class="service-hero-image-container">
                                    <img src="{{ asset($service?->image) }}" alt="{{ $service?->title }}" class="service-hero-main-image">
                                    <div class="service-hero-image-overlay"></div>
                                </div>
                                
                                <!-- Floating Badge -->
                                <div class="service-hero-floating-badge">
                                    <div class="floating-badge-content">
                                        <i class="fas fa-award"></i>
                                        <span>{{ __('Premium Quality') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Service Details Content -->
    <div class="service-details-content space" id="service-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10">
                    <div class="service-content-wrapper">
                        <div class="service-description">
                            {!! clean(replaceImageSources($service?->description)) !!}
                        </div>

                        <!-- Service Features -->
                        <div class="service-features-section">
                            <h3 class="features-title">{{ __('What You Get') }}</h3>
                            <div class="features-grid">
                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="feature-content">
                                        <h4>{{ __('Professional Quality') }}</h4>
                                        <p>{{ __('High-quality work delivered by experienced professionals') }}</p>
                                    </div>
                                </div>
                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <i class="fas fa-rocket"></i>
                                    </div>
                                    <div class="feature-content">
                                        <h4>{{ __('Fast Turnaround') }}</h4>
                                        <p>{{ __('Quick delivery without compromising on quality') }}</p>
                                    </div>
                                </div>
                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <i class="fas fa-headset"></i>
                                    </div>
                                    <div class="feature-content">
                                        <h4>{{ __('24/7 Support') }}</h4>
                                        <p>{{ __('Round-the-clock support for all your queries') }}</p>
                                    </div>
                                </div>
                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <i class="fas fa-shield-alt"></i>
                                    </div>
                                    <div class="feature-content">
                                        <h4>{{ __('Money Back Guarantee') }}</h4>
                                        <p>{{ __('100% satisfaction guaranteed or your money back') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Service Projects Section -->
    @if($service->projects->count() > 0)
    <div class="service-projects-section space-bottom">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-header text-center">
                        <h2 class="section-title">{{ __('Related Projects') }}</h2>
                        <p class="section-subtitle">{{ __('Check out some of our amazing work in this service category') }}</p>
                    </div>
                </div>
            </div>
            <div class="row gy-4">
                @foreach ($service->projects as $index => $project)
                    <div class="col-lg-6 col-md-6">
                        <div class="modern-project-card">
                            <div class="project-image-wrapper">
                                <img src="{{ asset($project?->image) }}" alt="{{ $project?->title }}" class="project-image">
                                <div class="project-overlay">
                                    <div class="project-category">{{ $project?->project_category }}</div>
                                    <a href="{{ route('single.portfolio', $project?->slug) }}" class="project-view-btn">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="project-content">
                                <h4 class="project-title">
                                    <a href="{{ route('single.portfolio', $project?->slug) }}">{{ $project?->title }}</a>
                                </h4>
                                <a href="{{ route('single.portfolio', $project?->slug) }}" class="project-link">
                                    {{ __('View Project') }}
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

                <br>


                 <div class="col-xl-8" style="margin-top: 90px !important; ">
                    <div class="row">
                        <h3 class="mt-5 mb-5">Service FAQs</h3>
                    </div>
                </div>
                <div>
                    {{-- FAQ --}}
                    @if ($sectionSetting?->faq_section)
                        <!-- faq-area -->
                        @include('frontend.home.four.sections.faq-area')
                        <!-- faq-area-end -->
                    @endif
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
