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
                                    <span class="btn-text">{{ $service?->btn_text ?? 'View Details' }}</span>
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

    <!-- Contact Form Section -->
    <div class="services-contact-section space-bottom">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10">
                    <div class="contact-form-wrapper">
                        <div class="contact-form-header text-center mb-5">
                            <h3 class="contact-form-title">{{ __('Get In Touch') }}</h3>
                            <p class="contact-form-subtitle">{{ __('Ready to start your project? Contact us today and let\'s discuss how we can help you achieve your goals.') }}</p>
                        </div>
                        
                        <!-- Success/Error Messages -->
                        <div id="form-messages" class="mb-4" style="display: none;">
                            <div id="success-message" class="alert alert-success" style="display: none;">
                                <i class="fas fa-check-circle me-2"></i>
                                <span>{{ __('Message sent successfully! We\'ll get back to you soon.') }}</span>
                            </div>
                            <div id="error-message" class="alert alert-danger" style="display: none;">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <span>{{ __('Something went wrong. Please try again.') }}</span>
                            </div>
                        </div>
                        
                        <form id="contact-form" class="modern-contact-form" action="{{ route('send-contact-message') }}" method="POST">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" id="name" name="name" class="form-control" placeholder=" " required>
                                        <label for="name" class="form-label">{{ __('Full Name') }}</label>
                                        <div class="form-icon">
                                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="email" id="email" name="email" class="form-control" placeholder=" " required>
                                        <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                        <div class="form-icon">
                                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                                <rect x="2" y="4" width="20" height="16" rx="2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="m22 7-10 5L2 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="url" id="website" name="website" class="form-control" placeholder=" ">
                                        <label for="website" class="form-label">{{ __('Website (Optional)') }}</label>
                                        <div class="form-icon">
                                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                                                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" stroke="currentColor" stroke-width="2"/>
                                                <path d="M8 12h8" stroke="currentColor" stroke-width="2"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select id="subject" name="subject" class="form-control" required>
                                            <option value="">{{ __('Select a subject') }}</option>
                                            @foreach($services as $service)
                                                <option value="Inquiry about {{ $service->title }}">{{ $service->title }}</option>
                                            @endforeach
                                            <option value="General Inquiry">{{ __('General Inquiry') }}</option>
                                            <option value="Quote Request">{{ __('Quote Request') }}</option>
                                            <option value="Support">{{ __('Support') }}</option>
                                        </select>
                                        <label for="subject" class="form-label">{{ __('Subject') }}</label>
                                        <div class="form-icon">
                                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                                <path d="M8 9l4-4 4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M16 15l-4 4-4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <textarea id="message" name="message" class="form-control" rows="5" placeholder=" " required></textarea>
                                        <label for="message" class="form-label">{{ __('Message') }}</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-submit text-center">
                                        <button type="submit" class="contact-submit-btn" id="submit-btn">
                                            <span class="btn-text">{{ __('Send Message') }}</span>
                                            <span class="btn-icon">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                                    <line x1="22" y1="2" x2="11" y2="13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <polygon points="22,2 15,22 11,13 2,9 22,2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </span>
                                            <div class="spinner-border spinner-border-sm" role="status" style="display: none;">
                                                <span class="visually-hidden">{{ __('Loading...') }}</span>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
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
        btnText.text('Sending...');
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
                    errorMessage.find('span').text('Something went wrong. Please try again.');
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
                btnText.text('Send Message');
                spinner.hide();
                btnIcon.show();
            }
        });
    });
});
</script>
@endpush
