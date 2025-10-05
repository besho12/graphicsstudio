@extends('frontend.layouts.master')

@section('meta_title', $seo_setting['contact_page']['seo_title'])
@section('meta_description', $seo_setting['contact_page']['seo_description'])

@section('header')
    @include('frontend.layouts.header-layout.three')
@endsection

@push('css')
    <link rel="stylesheet" href="{{asset('frontend/css/modern-contact-page.css')}}?v={{time()}}">
@endpush

@section('contents')
    <!-- Modern Hero Section -->
    <section class="contact-hero-modern">
        <div class="container">
            <div class="hero-content-modern">
                <div class="hero-badge-modern">
                    <i class="fas fa-comments"></i>
                    {{__('Get In Touch')}}
                </div>
                <h1 class="hero-title-modern">{{__('Let\'s Start a Conversation')}}</h1>
                <p class="hero-description-modern">
                    {{__('Ready to transform your ideas into reality? We\'re here to help you every step of the way. Reach out and let\'s create something amazing together.')}}
                </p>
                <div class="hero-stats-modern">
                    <div class="hero-stat-item">
                        <span class="hero-stat-number">24/7</span>
                        <span class="hero-stat-label">{{__('Support')}}</span>
                    </div>
                    <div class="hero-stat-item">
                        <span class="hero-stat-number">< 1hr</span>
                        <span class="hero-stat-label">{{__('Response Time')}}</span>
                    </div>
                    <div class="hero-stat-item">
                        <span class="hero-stat-number">100%</span>
                        <span class="hero-stat-label">{{__('Satisfaction')}}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modern Contact Info Cards -->
    <section class="contact-info-section-modern">
        <div class="container">
            <div class="contact-cards-grid">
                <div class="contact-card-modern">
                    <div class="contact-card-icon-modern">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3 class="contact-card-title-modern">{{__('Visit Our Office')}}</h3>
                    <div class="contact-card-content-modern">
                        <p class="contact-card-text-modern">{{__('Come and visit our headquarters for a face-to-face consultation.')}}</p>
                        <p class="contact-card-text-modern">{{ $contactSection?->address }}</p>
                    </div>
                    <a href="{{ $contactSection?->map }}" 
                       target="_blank" class="contact-card-link-modern">
                        {{__('Get Directions')}}
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                <div class="contact-card-modern">
                    <div class="contact-card-icon-modern">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3 class="contact-card-title-modern">{{__('Email Us')}}</h3>
                    <div class="contact-card-content-modern">
                        <p class="contact-card-text-modern">{{__('Send us an email and we\'ll get back to you within 24 hours.')}}</p>
                        <p class="contact-card-text-modern">{{ $contactSection?->email }}</p>
                        @if($contactSection?->email_two)
                            <p class="contact-card-text-modern">{{ $contactSection?->email_two }}</p>
                        @endif
                    </div>
                    <a href="mailto:{{ $contactSection?->email }}" 
                       class="contact-card-link-modern">
                        {{__('Send Email')}}
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                <div class="contact-card-modern">
                    <div class="contact-card-icon-modern">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h3 class="contact-card-title-modern">{{__('Call Us')}}</h3>
                    <div class="contact-card-content-modern">
                        <p class="contact-card-text-modern">{{__('Give us a call for immediate assistance and consultation.')}}</p>
                        <p class="contact-card-text-modern">{{ $contactSection?->phone }}</p>
                        @if($contactSection?->phone_two)
                            <p class="contact-card-text-modern">{{ $contactSection?->phone_two }}</p>
                        @endif
                    </div>
                    <a href="tel:{{ $contactSection?->phone }}" 
                       class="contact-card-link-modern">
                        {{__('Call Now')}}
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Modern Contact Form Section -->
    <section class="contact-form-section-modern">
        <div class="container">
            <div class="contact-form-container-modern">
                <div class="contact-form-info-modern">
                    <h2 class="contact-form-title-modern">{{ __('Ready to Get Started?') }}</h2>
                    <p class="contact-form-subtitle-modern">
                        {{ __("Fill out the form and our team will get back to you within 24 hours.") }}
                    </p>
                    
                    <ul class="contact-form-features">
                        <li class="contact-form-feature">
                            <div class="contact-form-feature-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <p class="contact-form-feature-text">{{__('Quick Response Time')}}</p>
                        </li>
                        <li class="contact-form-feature">
                            <div class="contact-form-feature-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <p class="contact-form-feature-text">{{__('100% Secure & Confidential')}}</p>
                        </li>
                        <li class="contact-form-feature">
                            <div class="contact-form-feature-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <p class="contact-form-feature-text">{{__('Expert Team Support')}}</p>
                        </li>
                        <li class="contact-form-feature">
                            <div class="contact-form-feature-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <p class="contact-form-feature-text">{{__('Premium Quality Service')}}</p>
                        </li>
                    </ul>
                </div>

                <div class="contact-form-modern">
                    <form action="{{ route('send-contact-message') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row-modern">
                            <div class="form-group-modern">
                                <input type="text" name="name" class="form-control-modern" placeholder=" " value="{{ old('name') }}" required>
                                <label class="form-label-modern">{{__('Your Name')}}</label>
                            </div>
                            <div class="form-group-modern">
                                <input type="email" name="email" class="form-control-modern" placeholder=" " value="{{ old('email') }}" required>
                                <label class="form-label-modern">{{__('Your Email')}}</label>
                            </div>
                        </div>
                        
                        <div class="form-row-modern">
                            <div class="form-group-modern">
                                <input type="text" name="website" class="form-control-modern" placeholder=" " value="{{ old('website') }}">
                                <label class="form-label-modern">{{__('Your Website')}}</label>
                            </div>
                            <div class="form-group-modern">
                                <input type="text" name="subject" class="form-control-modern" placeholder=" " value="{{ old('subject') }}" required>
                                <label class="form-label-modern">{{__('Subject')}}</label>
                            </div>
                        </div>
                        
                        <div class="form-group-modern">
                            <textarea name="message" class="form-control-modern textarea-modern" placeholder=" " rows="5" required>{{ old('message') }}</textarea>
                            <label class="form-label-modern">{{__('Your Message')}}</label>
                        </div>
                        
                        @if ($setting?->recaptcha_status == 'active')
                            <div class="form-group-modern">
                                <div class="g-recaptcha" data-sitekey="{{ $setting?->recaptcha_site_key }}"></div>
                            </div>
                        @endif
                        
                        <button type="submit" class="contact-submit-btn-modern">
                            {{__('Send Message')}}
                            <i class="fas fa-paper-plane btn-icon"></i>
                        </button>
                    </form>
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
