@extends('frontend.layouts.master')

@section('meta_title', $seo_setting['service_page']['seo_title'])
@section('meta_description', $seo_setting['service_page']['seo_description'])

@section('header')
    @include('frontend.layouts.header-layout.three')
@endsection

@section('contents')
    <!-- Breadcumb Area -->
    <x-breadcrumb :image="$setting?->service_page_breadcrumb_image" :title="__('Service')" />

    <!-- Main Services Area -->
    <div class="services-main-area space">
        <div class="container">
            <!-- Services Grid -->
            <div class="row gy-5 justify-content-center">
                @forelse ($services as $index => $service)
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="modern-service-card {{ $index % 2 == 0 ? 'card-style-primary' : 'card-style-secondary' }}">
                            <div class="service-card-header">
                                <div class="service-icon-wrapper">
                                    <img src="{{ asset($service?->icon) }}" alt="{{ $service?->title }}" class="service-icon">
                                    <div class="icon-bg-effect"></div>
                                </div>
                                <div class="service-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                            </div>
                            <div class="service-card-body">
                                <h4 class="service-title">
                                    <a href="{{ route('single.service', $service?->slug) }}">{{ $service?->title }}</a>
                                </h4>
                                <p class="service-description">{{ $service?->short_description }}</p>
                                <div class="service-features">
                                    <ul class="feature-list">
                                        <li>{{ __('Professional Quality') }}</li>
                                        <li>{{ __('Fast Delivery') }}</li>
                                        <li>{{ __('24/7 Support') }}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="service-card-footer">
                                <a href="{{ route('single.service', $service?->slug) }}" class="modern-btn">
                                    <span class="btn-text">{{ $service?->btn_text ?? __('View Details') }}</span>
                                    <span class="btn-icon">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                            <path d="M1 8H15M15 8L8 1M15 8L8 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <x-data-not-found />
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($services->hasPages())
                <div class="services-pagination mt-80">
                    <div class="row justify-content-center">
                        <div class="col-auto">
                            {{ $services->onEachSide(0)->links('frontend.pagination.custom') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="services-contact-section space-bottom">
        <div class="container">
            <div class="contact-form-wrapper">
                <div class="contact-form-header">
                    <h2 class="contact-form-title">{{ __('Ready to Get Started?') }}</h2>
                    <p class="contact-form-subtitle">
                        {{ __("Fill out the form and our team will get back to you within 24 hours.") }}
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
                                <input type="text" name="subject" class="form-control" placeholder=" " value="{{ old('subject') }}" required>
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




    <!--  Marquee Area -->
    @include('frontend.partials.marquee')
@endsection
@section('footer')
    @include('frontend.layouts.footer-layout.two')
@endsection

@push('scripts')
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
        
        // Show loading state
                submitBtn.prop('disabled', true);
                btnText.text('{{ __("Sending...") }}');
                btnIcon.hide();
                spinner.show();
        
        // Hide previous messages
        formMessages.hide();
        successMessage.hide();
        errorMessage.hide();
        
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                // Show success message
                successMessage.show();
                formMessages.show();
                
                // Reset form
                form[0].reset();
                
                // Scroll to messages
                $('html, body').animate({
                    scrollTop: formMessages.offset().top - 100
                }, 500);
            },
            error: function(xhr) {
                // Show error message
                if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage.find('span').text(xhr.responseJSON.message);
                    } else {
                        errorMessage.find('span').text('{{ __("Something went wrong. Please try again.") }}');
                    }
                errorMessage.show();
                formMessages.show();
                
                // Scroll to messages
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
@endpush
