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

@push('css')
    <link rel="stylesheet" href="{{ asset('css/modern-service-details.css') }}">
    <link rel="stylesheet" href="{{ asset('css/service-sections-redesign.css') }}">
@endpush

@section('header')
    @include('frontend.layouts.header-layout.three')
@endsection

@section('contents')
    <!-- breadcrumb-area -->
    <x-breadcrumb-two :title="$service?->title" :links="[['url' => route('home'), 'text' => __('Home')],['url' => route('services'), 'text' => __('Service')]]" />

    <!-- Revolutionary Service Hero Section -->
    <section class="service-hero-revolutionary">
        <!-- Animated Background Elements -->
        <div class="hero-bg-elements">
            <div class="floating-orb orb-1"></div>
            <div class="floating-orb orb-2"></div>
            <div class="floating-orb orb-3"></div>
            <div class="gradient-mesh"></div>
            <div class="particle-field"></div>
        </div>
        
        <!-- Main Hero Container -->
        <div class="hero-main-container">
            <div class="container-fluid px-0">
                <div class="row min-vh-0 align-items-center mx-0">
                    <!-- Content Section -->
                    <div class="col-lg-6">
                        <div class="hero-content-wrapper">
                            <!-- Service Category Badge -->
                            
                            
                            <!-- Hero Title with Gradient Text -->
                            <h1 class="hero-main-title" data-aos="fade-up" data-aos-delay="200">
                                <span class="title-line-1">{{ explode(' ', $service?->title)[0] ?? 'Service' }}</span>
                                <span class="title-line-2 gradient-text">
                                    {{ implode(' ', array_slice(explode(' ', $service?->title), 1)) ?: 'Excellence' }}
                                </span>
                            </h1>
                            
                            <!-- Enhanced Description -->
                            <p class="hero-description" data-aos="fade-up" data-aos-delay="300">
                                {{ Str::limit(strip_tags($service?->description), 180) }}
                            </p>
                            
                            <!-- Stats Cards -->
                            <div class="hero-stats-grid" data-aos="fade-up" data-aos-delay="400">
                                <div class="stat-card">
                                    <div class="stat-icon">
                                        <i class="fas fa-award"></i>
                                    </div>
                                    <div class="stat-content">
                                        <span class="stat-number">100%</span>
                                        <span class="stat-label">{{ __('Quality') }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- CTA Buttons -->
                            <div class="hero-cta-section" data-aos="fade-up" data-aos-delay="500">
                                <a href="#service-content" class="cta-primary">
                                    <span class="btn-text">{{ __('Explore Service') }}</span>
                                    <div class="btn-icon">
                                        <i class="fas fa-arrow-right"></i>
                                    </div>
                                    <div class="btn-ripple"></div>
                                </a>
                                <a href="#contact" class="cta-secondary">
                                    <span class="btn-text">{{ __('Get Quote') }}</span>
                                    <div class="btn-icon">
                                        <i class="fas fa-paper-plane"></i>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Visual Section -->
                    <div class="col-lg-6 col-md-12">
                        <div class="hero-visual-section" data-aos="fade-left" data-aos-delay="600">
                            <!-- Main Image Container -->
                            <div class="hero-image-container">
                                <div class="image-frame">
                                    <img src="{{ asset($service?->image) }}" alt="{{ $service?->title }}" class="hero-main-image" 
                                        
                                    {{-- <div class="image-overlay"></div> --}}
                                </div>
                                
                                <!-- Floating Info Cards -->
                                <div class="floating-info-card card-1">
                                    <div class="info-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="info-content">
                                        <span class="info-title">{{ __('Verified') }}</span>
                                        <span class="info-subtitle">{{ __('Quality Assured') }}</span>
                                    </div>
                                </div>
                                
                                <div class="floating-info-card card-2">
                                    <div class="info-icon">
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <div class="info-content">
                                        <span class="info-title">5.0</span>
                                        <span class="info-subtitle">{{ __('Rating') }}</span>
                                    </div>
                                </div>
                                
                                
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Scroll Indicator -->
        <div class="scroll-indicator">
            <div class="scroll-text">{{ __('Scroll to explore') }}</div>
            <div class="scroll-arrow">
                <i class="fas fa-chevron-down"></i>
            </div>
        </div>
    </section>

    <!-- Modern Service Details Content -->
    <section class="service-details-content-modern" id="service-content">
        <div class="container">
            <!-- Service Overview Section - Redesigned -->
            <div class="service-overview-modern-section">
                <div class="section-header-modern">
                    <div class="section-badge">
                        <i class="fas fa-info-circle"></i>
                        <span>{{ __('Overview') }}</span>
                    </div>
                    <h2 class="section-title">{{ __('Service Overview') }}</h2>
                    <p class="section-subtitle">{{ __('Everything you need to know about our professional service') }}</p>
                </div>

                <div class="overview-content-grid-modern">
                    <!-- Left Column -->
                    <div class="overview-content-left-modern">
                        <!-- Service Description -->
                        <div class="service-description-card-modern">
                            <div class="description-header-modern">
                                <div class="description-icon-modern">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <h3>{{ __('About This Service') }}</h3>
                            </div>
                            <div class="description-content-modern">
                                {!! clean(replaceImageSources($service?->description)) !!}
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="overview-content-right-modern">
                        <!-- Why Choose Us -->
                        <div class="key-benefits-overview-modern">
                            <div class="benefits-header-overview-modern">
                                <h3>{{ __('Why Choose Us') }}</h3>
                                <p>{{ __('Key advantages that make us your best choice') }}</p>
                            </div>
                            <div class="benefits-grid-overview-modern">
                                <div class="benefit-card-overview-modern primary">
                                    <div class="benefit-icon-overview-modern">
                                        <i class="fas fa-award"></i>
                                    </div>
                                    <div class="benefit-content-overview-modern">
                                        <h4>{{ __('Premium Quality') }}</h4>
                                        <p>{{ __('Exceptional standards in every project') }}</p>
                                    </div>
                                </div>
                                <div class="benefit-card-overview-modern secondary">
                                    <div class="benefit-icon-overview-modern">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div class="benefit-content-overview-modern">
                                        <h4>{{ __('Fast Delivery') }}</h4>
                                        <p>{{ __('Quick turnaround without compromising quality') }}</p>
                                    </div>
                                </div>
                                <div class="benefit-card-overview-modern accent">
                                    <div class="benefit-icon-overview-modern">
                                        <i class="fas fa-headset"></i>
                                    </div>
                                    <div class="benefit-content-overview-modern">
                                        <h4>{{ __('24/7 Support') }}</h4>
                                        <p>{{ __('Always available when you need us') }}</p>
                                    </div>
                                </div>
                                <div class="benefit-card-overview-modern success">
                                    <div class="benefit-icon-overview-modern">
                                        <i class="fas fa-shield-check"></i>
                                    </div>
                                    <div class="benefit-content-overview-modern">
                                        <h4>{{ __('Guaranteed Results') }}</h4>
                                        <p>{{ __('100% satisfaction or money back') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Service Guarantee -->
                        <div class="service-guarantee-card-modern">
                            <div class="guarantee-icon-modern">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div class="guarantee-content-modern">
                                <h4>{{ __('100% Satisfaction Guarantee') }}</h4>
                                <p>{{ __('We stand behind our work with complete confidence. If you\'re not satisfied, we\'ll make it right or refund your investment.') }}</p>
                            </div>
                            <div class="guarantee-badge-modern">
                                <span>{{ __('Risk Free') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service Features Section -->
            <div class="service-features-modern-section">
                <div class="section-header-modern">
                    <div class="section-badge">
                        <i class="fas fa-star"></i>
                        <span>{{ __('Features') }}</span>
                    </div>
                    <h2 class="section-title">{{ __('What Makes Us Different') }}</h2>
                    <p class="section-subtitle">{{ __('Discover the unique advantages that set our service apart from the competition') }}</p>
                </div>
                
                <div class="features-grid-modern">
                    <div class="feature-card-modern">
                        <div class="feature-card-header">
                            <div class="feature-icon-modern">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <h4>{{ __('Professional Quality') }}</h4>
                        </div>
                        <div class="feature-card-body">
                            <p>{{ __('High-quality work delivered by experienced professionals with years of expertise in the field') }}</p>
                        </div>
                        <div class="feature-card-footer">
                            <div class="feature-highlight">
                                <i class="fas fa-certificate"></i>
                                <span>{{ __('Certified Experts') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="feature-card-modern">
                        <div class="feature-card-header">
                            <div class="feature-icon-modern">
                                <i class="fas fa-rocket"></i>
                            </div>
                            <h4>{{ __('Fast Turnaround') }}</h4>
                        </div>
                        <div class="feature-card-body">
                            <p>{{ __('Quick delivery without compromising on quality, ensuring your project meets all deadlines') }}</p>
                        </div>
                        <div class="feature-card-footer">
                            <div class="feature-highlight">
                                <i class="fas fa-stopwatch"></i>
                                <span>{{ __('Express Delivery') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="feature-card-modern">
                        <div class="feature-card-header">
                            <div class="feature-icon-modern">
                                <i class="fas fa-headset"></i>
                            </div>
                            <h4>{{ __('24/7 Support') }}</h4>
                        </div>
                        <div class="feature-card-body">
                            <p>{{ __('Round-the-clock support for all your queries with dedicated customer service representatives') }}</p>
                        </div>
                        <div class="feature-card-footer">
                            <div class="feature-highlight">
                                <i class="fas fa-phone"></i>
                                <span>{{ __('Always Available') }}</span>
                            </div>
                        </div>
                    </div>
                    
                   
                    </div>
                </div>
            </div>

            <!-- Process Section -->
            <div class="service-process-section">
                <div class="section-header-modern">
                    <div class="section-badge">
                        <i class="fas fa-cogs"></i>
                        <span>{{ __('Our Process') }}</span>
                    </div>
                    <h2 class="section-title">{{ __('How We Work') }}</h2>
                    <p class="section-subtitle">{{ __('A streamlined process designed to deliver exceptional results efficiently') }}</p>
                </div>
                
                <div class="process-timeline">
                    <div class="process-step">
                        <div class="process-step-number">01</div>
                        <div class="process-step-content">
                            <h4>{{ __('Discovery & Planning') }}</h4>
                            <p>{{ __('We start by understanding your requirements and creating a detailed project plan') }}</p>
                        </div>
                    </div>
                    <div class="process-step">
                        <div class="process-step-number">02</div>
                        <div class="process-step-content">
                            <h4>{{ __('Design & Development') }}</h4>
                            <p>{{ __('Our expert team begins crafting your solution with attention to every detail') }}</p>
                        </div>
                    </div>
                    <div class="process-step">
                        <div class="process-step-number">03</div>
                        <div class="process-step-content">
                            <h4>{{ __('Review & Refinement') }}</h4>
                            <p>{{ __('We review the work with you and make any necessary adjustments') }}</p>
                        </div>
                    </div>
                    <div class="process-step">
                        <div class="process-step-number">04</div>
                        <div class="process-step-content">
                            <h4>{{ __('Delivery & Support') }}</h4>
                            <p>{{ __('Final delivery with ongoing support to ensure your complete satisfaction') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Work Section - Enhanced Modern Redesign -->
    @if($service->projects->count() > 0)
    <section class="latest-work-modern-section">
        <div class="container">
            <div class="section-header-modern">
                <div class="section-badge-enhanced">
                    <div class="badge-icon-wrapper">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <span>{{ __('Portfolio') }}</span>
                </div>
                <h2 class="section-title-enhanced">{{ __('Our Latest Work') }}</h2>
                <p class="section-subtitle-enhanced">{{ __('Explore our portfolio of successful projects that showcase our expertise and creativity') }}</p>
                <div class="section-divider-enhanced"></div>
            </div>
            
            <div class="projects-showcase-grid">
                @foreach ($service->projects as $index => $project)
                    <div class="project-showcase-card" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <div class="project-image-wrapper-enhanced">
                            <div class="project-image-overlay-bg"></div>
                            <img src="{{ asset($project?->image) }}" alt="{{ $project?->title }}" class="project-image-enhanced">
                            <div class="project-hover-overlay">
                                <div class="project-overlay-content-enhanced">
                                    <div class="project-category-tag">
                                        <i class="fas fa-tag"></i>
                                        <span>{{ $project?->project_category }}</span>
                                    </div>
                                    <div class="project-actions-enhanced">
                                        <a href="{{ route('single.portfolio', $project?->slug) }}" class="project-action-btn primary">
                                            <i class="fas fa-eye"></i>
                                            <span>{{ __('View Details') }}</span>
                                        </a>
                                        <a href="{{ asset($project?->image) }}" class="project-action-btn secondary" data-lightbox="project-gallery">
                                            <i class="fas fa-expand-arrows-alt"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="project-status-indicator">
                                <span class="status-dot"></span>
                                <span class="status-text">{{ __('Completed') }}</span>
                            </div>
                        </div>
                        <div class="project-content-enhanced">
                            <div class="project-meta-enhanced">
                                <div class="project-category-chip">
                                    <i class="fas fa-folder"></i>
                                    <span>{{ $project?->project_category }}</span>
                                </div>
                                <div class="project-date-chip">
                                    <i class="fas fa-calendar"></i>
                                    <span>{{ $project?->created_at?->format('M Y') }}</span>
                                </div>
                            </div>
                            <h4 class="project-title-enhanced">
                                <a href="{{ route('single.portfolio', $project?->slug) }}">{{ $project?->title }}</a>
                            </h4>
                            <p class="project-description-enhanced">{{ Str::limit($project?->description, 120) }}</p>
                            <div class="project-footer-enhanced">
                                <a href="{{ route('single.portfolio', $project?->slug) }}" class="project-cta-link">
                                    <span>{{ __('View Project') }}</span>
                                    <div class="cta-arrow">
                                        <i class="fas fa-arrow-right"></i>
                                    </div>
                                </a>
                                <div class="project-engagement">
                                    <div class="engagement-item">
                                        <i class="fas fa-heart"></i>
                                        <span>{{ rand(15, 99) }}</span>
                                    </div>
                                    <div class="engagement-item">
                                        <i class="fas fa-eye"></i>
                                        <span>{{ rand(100, 999) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="projects-cta">
                <a href="{{ route('portfolios') }}" class="btn-modern-primary">
                    {{ __('View All Projects') }}
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            
            <div class="projects-cta-section">
                <div class="cta-content">
                    <h3>{{ __('Like What You See?') }}</h3>
                    <p>{{ __('Ready to start your own project? Let\'s discuss how we can bring your vision to life.') }}</p>
                </div>
                <div class="cta-actions">
                    <a href="#contact" class="cta-btn primary">
                        <span>{{ __('Start Your Project') }}</span>
                        <i class="fas fa-rocket"></i>
                    </a>
                    <a href="{{ route('portfolios') }}" class="cta-btn secondary">
                        <span>{{ __('View All Work') }}</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Service FAQ Section - Enhanced Modern Redesign -->
    <section class="service-faq-modern-section">
        <div class="container">
            <div class="section-header-modern">
                <div class="section-badge-enhanced">
                    <div class="badge-icon-wrapper">
                        <i class="fas fa-question-circle"></i>
                    </div>
                    <span>{{ __('FAQ') }}</span>
                </div>
                <h2 class="section-title-enhanced">{{ $serviceSection?->getTranslation(app()->getLocale())?->content?->title ?? __('Frequently Asked Questions') }}</h2>
                <p class="section-subtitle-enhanced">{{ $serviceSection?->getTranslation(app()->getLocale())?->content?->sub_title ?? __('Find answers to common questions about our services and process') }}</p>
                <div class="section-divider-enhanced"></div>
            </div>
            
            <div class="faq-content-wrapper">
                <div class="faq-intro-card">
                    <div class="faq-intro-icon">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <div class="faq-intro-content">
                        <h3>{{ __('Got Questions?') }}</h3>
                        <p>{{ __('We\'ve compiled answers to the most common questions about our services. Can\'t find what you\'re looking for? Feel free to contact us directly.') }}</p>
                    </div>
                </div>
                
                @if ($sectionSetting?->faq_section)
                    <div class="faq-modern-wrapper">
                        @include('frontend.home.four.sections.faq-area')
                    </div>
                @else
                    <div class="faq-placeholder">
                        <div class="placeholder-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <h4>{{ __('FAQ Coming Soon') }}</h4>
                        <p>{{ __('We\'re preparing comprehensive answers to help you better understand our services.') }}</p>
                        <a href="#contact" class="placeholder-cta">
                            <span>{{ __('Ask Us Directly') }}</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                @endif
                
                <div class="faq-contact-card">
                    <div class="faq-contact-content">
                        <div class="contact-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div class="contact-text">
                            <h4>{{ __('Still Have Questions?') }}</h4>
                            <p>{{ __('Our support team is here to help you with any additional questions.') }}</p>
                        </div>
                    </div>
                    <div class="contact-actions">
                        <a href="#contact" class="contact-btn primary">
                            <i class="fas fa-envelope"></i>
                            <span>{{ __('Contact Us') }}</span>
                        </a>
                        <a href="tel:+1234567890" class="contact-btn secondary">
                            <i class="fas fa-phone"></i>
                            <span>{{ __('Call Now') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <div class="contact-form-section space-bottom">
        <div class="container">
            <div class="contact-form-wrapper">
                <div class="contact-form-header">
                    <h2 class="contact-form-title">{{ __('Have Any Project on Your Mind?') }}</h2>
                    <p class="contact-form-subtitle">
                        {{ __("Great! We're excited to hear from you and let's start something") }}
                    </p>
                </div>

                <form action="{{ route('send-contact-message') }}" id="contact-form" class="modern-contact-form">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" placeholder=" " value="{{ old('name') }}" required>
                                <label class="form-label">{{__('Your Name')}}</label>
                                <div class="form-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" placeholder=" " value="{{ old('email') }}" required>
                                <label class="form-label">{{__('Your Email')}}</label>
                                <div class="form-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="website" class="form-control" placeholder=" " value="{{ old('website') }}">
                                <label class="form-label">{{__('Your Website')}}</label>
                                <div class="form-icon">
                                    <i class="fas fa-globe"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="subject" class="form-control" placeholder=" " value="{{ $service?->title }} - Service" required>
                                <label class="form-label">{{__('Subject')}}</label>
                                <div class="form-icon">
                                    <i class="fas fa-tag"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <textarea name="message" class="form-control" placeholder=" " rows="5" required>{{ old('message') }}</textarea>
                        <label class="form-label">{{__('Your Message')}}</label>
                        <div class="form-icon">
                            <i class="fas fa-comment"></i>
                        </div>
                    </div>
                    
                    @if ($setting?->recaptcha_status == 'active')
                        <div class="form-group">
                            <div class="g-recaptcha" data-sitekey="{{ $setting?->recaptcha_site_key }}"></div>
                        </div>
                    @endif
                    
                    <!-- Form Messages -->
                    <div id="form-messages" style="display: none;">
                        <div id="success-message" class="alert alert-success" style="display: none;">
                            <i class="fas fa-check-circle"></i>
                            <span>{{ __('Your message has been sent successfully!') }}</span>
                        </div>
                        <div id="error-message" class="alert alert-danger" style="display: none;">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ __('Something went wrong. Please try again.') }}</span>
                        </div>
                    </div>
                    
                    <button type="submit" id="submit-btn" class="contact-submit-btn">
                        <span class="btn-text">{{__('Send Message')}}</span>
                        <i class="fas fa-paper-plane btn-icon"></i>
                        <div class="spinner-border spinner-border-sm" role="status" style="display: none;">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </button>
                </form>
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

@section('scripts')
<script>
$(document).ready(function() {
    $('#contact-form').on('submit', function(e) {
        e.preventDefault();
        
        const form = $(this);
        const submitBtn = $('#submit-btn');
        const btnText = submitBtn.find('.btn-text');
        const btnIcon = submitBtn.find('.btn-icon');
        const spinner = submitBtn.find('.spinner-border');
        const formMessages = $('#form-messages');
        const successMessage = $('#success-message');
        const errorMessage = $('#error-message');
        
        // Reset messages
        formMessages.hide();
        successMessage.hide();
        errorMessage.hide();
        
        // Show loading state
        submitBtn.prop('disabled', true);
        btnText.text('{{ __("Sending...") }}');
        btnIcon.hide();
        spinner.show();
        
        // Get form data
        const formData = new FormData(form[0]);
        
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Show success message
                successMessage.show();
                formMessages.show();
                
                // Reset form
                form[0].reset();
                
                // Reset reCAPTCHA if present
                if (typeof grecaptcha !== 'undefined') {
                    grecaptcha.reset();
                }
                
                // Scroll to success message
                $('html, body').animate({
                    scrollTop: formMessages.offset().top - 100
                }, 500);
            },
            error: function(xhr) {
                // Show error message
                let errorText = '{{ __("Something went wrong. Please try again.") }}';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorText = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = Object.values(xhr.responseJSON.errors).flat();
                    errorText = errors.join(', ');
                }
                
                errorMessage.find('span').text(errorText);
                errorMessage.show();
                formMessages.show();
                
                // Scroll to error message
                $('html, body').animate({
                    scrollTop: formMessages.offset().top - 100
                }, 500);
            },
            complete: function() {
                // Reset button state
                submitBtn.prop('disabled', false);
                btnText.text('{{ __("Send Message") }}');
                spinner.hide();
                btnIcon.show();
            }
        });
    });
});
</script>
@endsection
