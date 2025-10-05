@extends('frontend.layouts.master')

@section('meta_title', $project?->seo_title . ' || ' . $setting->app_name)
@section('meta_description', $project?->seo_description)

@push('custom_meta')
    <meta property="og:title" content="{{ $project?->seo_title }}" />
    <meta property="og:description" content="{{ $project?->seo_description }}" />
    <meta property="og:image" content="{{ asset($project?->image) }}" />
    <meta property="og:URL" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
@endpush

@section('header')
    @include('frontend.layouts.header-layout.three')
@endsection

@section('contents')
    <!-- Modern Portfolio Details Section -->
    <div class="portfolio-details-modern">
        <!-- Hero Section -->
        <div class="portfolio-hero-section">
            <div class="portfolio-hero-overlay"></div>
            <div class="portfolio-hero-content">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <div class="portfolio-hero-text">
                                <div class="portfolio-breadcrumb">
                                    <a href="{{ route('home') }}" class="breadcrumb-link">
                                        <i class="fas fa-home"></i>
                                        {{ __('Home') }}
                                    </a>
                                    <span class="breadcrumb-separator">/</span>
                                    <a href="{{ route('portfolios') }}" class="breadcrumb-link">
                                        {{ __('Portfolio') }}
                                    </a>
                                    <span class="breadcrumb-separator">/</span>
                                    <span class="breadcrumb-current">{{ $project?->title }}</span>
                                </div>
                                <h1 class="portfolio-hero-title">{{ $project?->title }}</h1>
                                <div class="portfolio-hero-meta">
                                    <span class="portfolio-category-badge">
                                        <i class="fas fa-tag"></i>
                                        {{ $project?->project_category }}
                                    </span>
                                    <span class="portfolio-date">
                                        <i class="fas fa-calendar"></i>
                                        {{ formattedDate($project?->created_at) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="portfolio-hero-actions">
                                <a href="{{ route('portfolios') }}" class="back-to-portfolio-btn">
                                    <i class="fas fa-arrow-left"></i>
                                    {{ __('Back to Portfolio') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="portfolio-main-content">
            <div class="container">
                <!-- Gallery Section -->
                <div class="portfolio-gallery-section">
                    <div class="portfolio-gallery-wrapper">
                        @if($project?->gallery && count($project->gallery) > 0)
                        <!-- Multi-Image Gallery Grid -->
                        <div class="portfolio-gallery-grid">
                            <div class="gallery-main-image">
                                <img id="mainPortfolioImage" src="{{ asset($project?->image) }}" alt="{{ $project?->title }}" class="main-portfolio-image">
                                <div class="image-zoom-overlay">
                                    <button class="zoom-btn" data-image-src="{{ asset($project?->image) }}">
                                        <i class="fas fa-search-plus"></i>
                                    </button>
                                </div>
                                <div class="gallery-nav-controls">
                                    <button class="gallery-nav-btn prev-btn" data-action="previous">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <button class="gallery-nav-btn next-btn" data-action="next">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>
                                <div class="gallery-counter">
                                    <span id="currentImageIndex">1</span> / <span id="totalImages">{{ count($project->gallery) + 1 }}</span>
                                </div>
                            </div>
                            
                            <div class="gallery-sidebar">
                                <div class="gallery-thumbnail-grid">
                                    <div class="gallery-thumbnail active" data-index="0" data-image-src="{{ asset($project?->image) }}">
                                        <img src="{{ asset($project?->image) }}" alt="{{ $project?->title }}">
                                        <div class="thumbnail-overlay"></div>
                                    </div>
                                    @foreach($project->gallery as $index => $gallery)
                                    <div class="gallery-thumbnail" data-index="{{ $index + 1 }}" data-image-src="{{ asset($gallery->image) }}">
                                         <img src="{{ asset($gallery->image) }}" alt="{{ $project?->title }}">
                                         <div class="thumbnail-overlay"></div>
                                     </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @else
                        <!-- Single Image Display -->
                        <div class="portfolio-single-image">
                            <img id="mainPortfolioImage" src="{{ asset($project?->image) }}" alt="{{ $project?->title }}" class="main-portfolio-image">
                            <div class="image-zoom-overlay">
                                <button class="zoom-btn" data-image-src="{{ asset($project?->image) }}">
                                    <i class="fas fa-search-plus"></i>
                                </button>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Details Grid -->
                <div class="portfolio-details-grid">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="portfolio-content-section">
                                <h2 class="section-title">{{ __('Project Overview') }}</h2>
                                <div class="description-content">
                                    {!! $project?->description !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="portfolio-sidebar">
                                <div class="portfolio-info-card">
                                    <h3 class="info-card-title">{{ __('Project Details') }}</h3>
                                    <div class="info-list">
                                        @if($project?->project_category)
                                        <div class="info-item">
                                            <div class="info-icon">
                                                <i class="fas fa-tag"></i>
                                            </div>
                                            <div class="info-content">
                                                <div class="info-label">{{ __('Category') }}</div>
                                                <div class="info-value">{{ $project->project_category }}</div>
                                            </div>
                                        </div>
                                        @endif
                                        
                                        @if($project?->software)
                                        <div class="info-item">
                                            <div class="info-icon">
                                                <i class="fas fa-tools"></i>
                                            </div>
                                            <div class="info-content">
                                                <div class="info-label">{{ __('Software') }}</div>
                                                <div class="info-value">{{ $project->software }}</div>
                                            </div>
                                        </div>
                                        @endif
                                        
                                        @if($project?->service)
                                        <div class="info-item">
                                            <div class="info-icon">
                                                <i class="fas fa-cogs"></i>
                                            </div>
                                            <div class="info-content">
                                                <div class="info-label">{{ __('Service') }}</div>
                                                <div class="info-value">{{ $project->service }}</div>
                                            </div>
                                        </div>
                                        @endif
                                        
                                        @if($project?->client)
                                        <div class="info-item">
                                            <div class="info-icon">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div class="info-content">
                                                <div class="info-label">{{ __('Client') }}</div>
                                                <div class="info-value">{{ $project->client }}</div>
                                            </div>
                                        </div>
                                        @endif
                                        
                                        <div class="info-item">
                                            <div class="info-icon">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                            <div class="info-content">
                                                <div class="info-label">{{ __('Date') }}</div>
                                                <div class="info-value">{{ formattedDate($project?->created_at) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="portfolio-cta-card">
                                    <h3 class="cta-title">{{ __('Interested in Similar Work?') }}</h3>
                                    <p class="cta-description">{{ __('Let\'s discuss your project and bring your vision to life with our expertise.') }}</p>
                                    <a href="{{ route('contact') }}" class="cta-btn">
                                        <i class="fas fa-envelope"></i>
                                        {{ __('Get In Touch') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Section -->
                <div class="portfolio-navigation-section">
                    <div class="portfolio-nav-wrapper">
                        <div class="nav-item nav-prev">
                            @if($prevPost)
                            <a href="{{ route('single.portfolio', $prevPost->slug) }}" class="nav-link">
                                <div class="nav-icon">
                                    <i class="fas fa-chevron-left"></i>
                                </div>
                                <div class="nav-content">
                                    <div class="nav-label">{{ __('Previous') }}</div>
                                    <div class="nav-title">{{ Str::limit($prevPost->title, 20) }}</div>
                                </div>
                            </a>
                            @else
                            <div class="nav-link disabled">
                                <div class="nav-icon">
                                    <i class="fas fa-arrow-left"></i>
                                </div>
                                <div class="nav-content">
                                    <div class="nav-label">{{ __('Previous') }}</div>
                                    <div class="nav-title">{{ __('No Previous Project') }}</div>
                                </div>
                            </div>
                            @endif
                        </div>
                        
                        <div class="nav-center">
                            <a href="{{ route('portfolios') }}" class="portfolio-grid-btn">
                                <i class="fas fa-th"></i>
                                {{ __('All Projects') }}
                            </a>
                        </div>
                        
                        <div class="nav-item nav-next">
                            @if($nextPost)
                            <a href="{{ route('single.portfolio', $nextPost->slug) }}" class="nav-link">
                                <div class="nav-content">
                                    <div class="nav-label">{{ __('Next') }}</div>
                                    <div class="nav-title">{{ Str::limit($nextPost->title, 20) }}</div>
                                </div>
                                <div class="nav-icon">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </a>
                            @else
                            <div class="nav-link disabled">
                                <div class="nav-content">
                                    <div class="nav-label">{{ __('Next') }}</div>
                                    <div class="nav-title">{{ __('No Next Project') }}</div>
                                </div>
                                <div class="nav-icon">
                                    <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Contact Form Section -->
    <section class="services-contact-section space-bottom">
        <div class="container">
            <div class="contact-form-wrapper">
                <div class="contact-form-header">
                    <h2 class="contact-form-title">{{ __('Interested in Similar Work?') }}</h2>
                    <p class="contact-form-subtitle">
                        {{ __("Let's discuss your project and create something amazing together.") }}
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
                                <label class="form-label">{{__('Project Type')}}</label>
                                <div class="form-icon">
                                    <i class="fas fa-tag"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <textarea name="message" class="form-control" placeholder=" " rows="5" required>{{ old('message') }}</textarea>
                        <label class="form-label">{{__('Project Details')}}</label>
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
                        <span class="btn-text">{{__('Start Your Project')}}</span>
                        <i class="fas fa-rocket btn-icon"></i>
                        <div class="spinner-border spinner-border-sm" role="status" style="display: none;">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Image Modal -->
    <div id="imageModal" class="image-modal" data-action="close">
        <div class="modal-content">
            <span class="modal-close" data-action="close">&times;</span>
            <img id="modalImage" src="" alt="Portfolio Image">
        </div>
    </div>

    @include('frontend.partials.marquee')
@endsection

<style>
/* Portfolio Details Modern Styles */
.portfolio-details-modern {
    background: #1a252f;
    min-height: 100vh;
    color: #ecf0f1;
}

/* Hero Section */
.portfolio-hero-section {
    background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
    padding: 120px 0 80px;
    position: relative;
    overflow: hidden;
}

.portfolio-hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="%23ffffff" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="%23ffffff" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="%23ffffff" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.portfolio-hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, rgba(52, 152, 219, 0.1), rgba(41, 128, 185, 0.1));
}

.portfolio-hero-content {
    position: relative;
    z-index: 2;
}

.portfolio-breadcrumb {
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
}

.breadcrumb-link {
    color: #3498db;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: all 0.3s ease;
}

.breadcrumb-link:hover {
    color: #2980b9;
    text-decoration: none;
}

.breadcrumb-separator {
    color: #7f8c8d;
    font-size: 14px;
}

.breadcrumb-current {
    color: #ecf0f1;
    font-size: 14px;
    font-weight: 500;
}

.portfolio-hero-title {
    font-size: 3.5rem;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 30px;
    line-height: 1.2;
}

.portfolio-hero-meta {
    display: flex;
    align-items: center;
    gap: 30px;
    flex-wrap: wrap;
}

.portfolio-category-badge,
.portfolio-date {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: rgba(52, 152, 219, 0.2);
    border: 1px solid rgba(52, 152, 219, 0.3);
    border-radius: 25px;
    color: #3498db;
    font-size: 14px;
    font-weight: 500;
}

.back-to-portfolio-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 12px 24px;
    background: linear-gradient(45deg, #3498db, #2980b9);
    color: #ffffff;
    text-decoration: none;
    border-radius: 30px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
}

.back-to-portfolio-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
    color: #ffffff;
    text-decoration: none;
}

/* Main Content */
.portfolio-main-content {
    padding: 80px 0;
}

/* Gallery Section */
.portfolio-gallery-section {
    margin-bottom: 80px;
}

.portfolio-gallery-wrapper {
    background: #2c3e50;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}

/* Multi-Image Gallery Grid */
.portfolio-gallery-grid {
    display: grid;
    grid-template-columns: 1fr 200px;
    gap: 30px;
    align-items: start;
}

.gallery-main-image {
    position: relative;
    border-radius: 15px;
    overflow: hidden;
    background: #34495e;
}

.main-portfolio-image {
    width: 100%;
    height: auto;
    display: block;
    transition: transform 0.3s ease;
}

.image-zoom-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.gallery-main-image:hover .image-zoom-overlay {
    opacity: 1;
}

.zoom-btn {
    background: rgba(52, 152, 219, 0.9);
    border: none;
    color: #ffffff;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    font-size: 20px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.zoom-btn:hover {
    background: #3498db;
    transform: scale(1.1);
}

/* Gallery Navigation Controls */
.gallery-nav-controls {
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    transform: translateY(-50%);
    display: flex;
    justify-content: space-between;
    padding: 0 20px;
    pointer-events: none;
}

.gallery-nav-btn {
    background: rgba(52, 152, 219, 0.9);
    border: none;
    color: #ffffff;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    font-size: 18px;
    cursor: pointer;
    transition: all 0.3s ease;
    pointer-events: all;
    opacity: 0;
}

.gallery-main-image:hover .gallery-nav-btn {
    opacity: 1;
}

.gallery-nav-btn:hover {
    background: #3498db;
    transform: scale(1.1);
}

.gallery-nav-btn:disabled {
    background: rgba(127, 140, 141, 0.5);
    cursor: not-allowed;
    transform: none;
}

/* Gallery Counter */
.gallery-counter {
    position: absolute;
    bottom: 20px;
    right: 20px;
    background: rgba(0, 0, 0, 0.7);
    color: #ffffff;
    padding: 8px 15px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 500;
}

/* Gallery Sidebar */
.gallery-sidebar {
    display: flex;
    flex-direction: column;
}

.gallery-thumbnail-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
    max-height: 500px;
    overflow-y: auto;
}

.gallery-thumbnail {
    width: 100%;
    height: 80px;
    border-radius: 10px;
    overflow: hidden;
    cursor: pointer;
    position: relative;
    border: 3px solid transparent;
    transition: all 0.3s ease;
}

.gallery-thumbnail.active {
    border-color: #3498db;
}

.gallery-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.thumbnail-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.3);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.gallery-thumbnail:hover .thumbnail-overlay {
    opacity: 1;
}

.gallery-thumbnail.active .thumbnail-overlay {
    opacity: 0;
}

/* Single Image Display */
.portfolio-single-image {
    position: relative;
    border-radius: 15px;
    overflow: hidden;
    background: #34495e;
}

/* Legacy Thumbnail Gallery (for backward compatibility) */
.portfolio-thumbnail-gallery {
    margin-top: 20px;
}

.thumbnail-scroll-container {
    display: flex;
    gap: 15px;
    overflow-x: auto;
    padding: 10px 0;
}

.portfolio-thumbnail {
    flex: 0 0 auto;
    width: 100px;
    height: 80px;
    border-radius: 10px;
    overflow: hidden;
    cursor: pointer;
    position: relative;
    border: 3px solid transparent;
    transition: all 0.3s ease;
}

.portfolio-thumbnail.active {
    border-color: #3498db;
}

.portfolio-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.thumbnail-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.3);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.portfolio-thumbnail:hover .thumbnail-overlay {
    opacity: 1;
}

.portfolio-thumbnail.active .thumbnail-overlay {
    opacity: 0;
}

/* Details Grid */
.portfolio-details-grid {
    margin-bottom: 80px;
}

.portfolio-content-section {
    background: #2c3e50;
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}

.section-title {
    font-size: 2rem;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 30px;
    position: relative;
    padding-bottom: 15px;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 60px;
    height: 3px;
    background: linear-gradient(45deg, #3498db, #2980b9);
    border-radius: 2px;
}

.description-content {
    color: #ecf0f1;
    font-size: 16px;
    line-height: 1.8;
}

.description-content p {
    margin-bottom: 20px;
}

.description-content h1,
.description-content h2,
.description-content h3,
.description-content h4,
.description-content h5,
.description-content h6 {
    color: #ffffff;
    margin-top: 30px;
    margin-bottom: 15px;
}

/* Sidebar */
.portfolio-sidebar {
    display: flex;
    flex-direction: column;
    gap: 30px;
}

.portfolio-info-card,
.portfolio-cta-card {
    background: #2c3e50;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}

.info-card-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 25px;
    text-align: center;
}

.info-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.info-item {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    padding: 15px;
    background: rgba(52, 152, 219, 0.1);
    border-radius: 12px;
    border-left: 4px solid #3498db;
}

.info-icon {
    flex: 0 0 auto;
    width: 40px;
    height: 40px;
    background: linear-gradient(45deg, #3498db, #2980b9);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    font-size: 16px;
}

.info-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.info-label {
    font-size: 12px;
    font-weight: 600;
    color: #7f8c8d;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-value {
    font-size: 14px;
    font-weight: 500;
    color: #ecf0f1;
}

/* CTA Card */
.cta-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 15px;
    text-align: center;
}

.cta-description {
    color: #bdc3c7;
    font-size: 14px;
    text-align: center;
    margin-bottom: 25px;
    line-height: 1.6;
}

.cta-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 15px 30px;
    background: linear-gradient(45deg, #e74c3c, #c0392b);
    color: #ffffff;
    text-decoration: none;
    border-radius: 30px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
}

.cta-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(231, 76, 60, 0.4);
    color: #ffffff;
    text-decoration: none;
}

/* Navigation Section */
.portfolio-navigation-section {
    background: #2c3e50;
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}

.portfolio-nav-wrapper {
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    gap: 30px;
    align-items: center;
}

.nav-item {
    display: flex;
}

.nav-prev {
    justify-content: flex-start;
}

.nav-next {
    justify-content: flex-end;
}

.nav-link {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 20px 25px;
    background: rgba(52, 152, 219, 0.1);
    border: 1px solid rgba(52, 152, 219, 0.3);
    border-radius: 15px;
    color: #ecf0f1;
    text-decoration: none;
    transition: all 0.3s ease;
    max-width: 300px;
}

.nav-link:hover:not(.disabled) {
    background: rgba(52, 152, 219, 0.2);
    border-color: rgba(52, 152, 219, 0.5);
    transform: translateY(-2px);
    color: #ecf0f1;
    text-decoration: none;
}

.nav-link.disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.nav-icon {
    flex: 0 0 auto;
    width: 40px;
    height: 40px;
    background: linear-gradient(45deg, #3498db, #2980b9);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
}

.nav-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.nav-label {
    font-size: 12px;
    font-weight: 600;
    color: #7f8c8d;
    text-transform: uppercase;
}

.nav-title {
    font-size: 14px;
    font-weight: 600;
    color: #ecf0f1;
}

.nav-center {
    display: flex;
    justify-content: center;
}

.portfolio-grid-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 15px 25px;
    background: linear-gradient(45deg, #27ae60, #229954);
    color: #ffffff;
    text-decoration: none;
    border-radius: 30px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(39, 174, 96, 0.3);
}

.portfolio-grid-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(39, 174, 96, 0.4);
    color: #ffffff;
    text-decoration: none;
}

/* Image Modal */
.image-modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.9);
    animation: fadeIn 0.3s ease;
}

.modal-content {
    position: relative;
    margin: auto;
    padding: 20px;
    width: 90%;
    max-width: 1200px;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-content img {
    max-width: 100%;
    max-height: 90vh;
    object-fit: contain;
    border-radius: 10px;
}

.modal-close {
    position: absolute;
    top: 20px;
    right: 35px;
    color: #ffffff;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
    z-index: 10000;
}

.modal-close:hover {
    color: #3498db;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* Responsive Design */
@media (max-width: 1200px) {
    .portfolio-hero-title {
        font-size: 3rem;
    }
    
    .portfolio-nav-wrapper {
        grid-template-columns: 1fr;
        gap: 20px;
        text-align: center;
    }
    
    .nav-prev,
    .nav-next {
        justify-content: center;
    }
}

@media (max-width: 768px) {
    .portfolio-hero-section {
        padding: 80px 0 60px;
    }
    
    .portfolio-hero-title {
        font-size: 2.5rem;
    }
    
    .portfolio-hero-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }
    
    .portfolio-main-content {
        padding: 60px 0;
    }
    
    .portfolio-gallery-wrapper,
    .portfolio-content-section,
    .portfolio-info-card,
    .portfolio-cta-card,
    .portfolio-navigation-section {
        padding: 25px;
    }
    
    .portfolio-details-grid {
        margin-bottom: 60px;
    }
    
    .portfolio-gallery-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .gallery-sidebar {
        order: -1;
    }
    
    .gallery-thumbnail-grid {
        grid-template-columns: repeat(4, 1fr);
        max-height: none;
    }
    
    .gallery-thumbnail {
        height: 60px;
    }
    
    .thumbnail-scroll-container {
        gap: 10px;
    }
    
    .portfolio-thumbnail {
        width: 80px;
        height: 60px;
    }
    
    .nav-link {
        padding: 15px 20px;
        max-width: none;
    }
}

@media (max-width: 480px) {
    .portfolio-hero-title {
        font-size: 2rem;
    }
    
    .section-title {
        font-size: 1.5rem;
    }
    
    .portfolio-gallery-wrapper,
    .portfolio-content-section,
    .portfolio-info-card,
    .portfolio-cta-card,
    .portfolio-navigation-section {
        padding: 20px;
    }
    
    .info-item {
        padding: 12px;
    }
    
    .info-icon {
        width: 35px;
        height: 35px;
        font-size: 14px;
    }
}
</style>

<script>
// Gallery state
let currentImageIndex = 0;
let galleryImages = [];

// Initialize gallery on page load
document.addEventListener('DOMContentLoaded', function() {
    initializeGallery();
});

function initializeGallery() {
    // Collect all gallery images
    const thumbnails = document.querySelectorAll('.gallery-thumbnail');
    galleryImages = Array.from(thumbnails).map(thumb => {
        const img = thumb.querySelector('img');
        return img ? img.src : '';
    }).filter(src => src);
    
    // Add event listeners for gallery thumbnails
    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
            const imageSrc = this.getAttribute('data-image-src');
            const index = parseInt(this.getAttribute('data-index'));
            if (imageSrc !== null && !isNaN(index)) {
                changeMainImage(imageSrc, this, index);
            }
        });
    });
    
    // Add event listeners for navigation buttons
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    
    if (prevBtn) {
        prevBtn.addEventListener('click', previousImage);
    }
    
    if (nextBtn) {
        nextBtn.addEventListener('click', nextImage);
    }
    
    // Add event listeners for zoom buttons
    const zoomBtns = document.querySelectorAll('.zoom-btn');
    zoomBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const imageSrc = this.getAttribute('data-image-src');
            if (imageSrc) {
                openImageModal(imageSrc);
            }
        });
    });
    
    // Add event listeners for modal close
    const modal = document.getElementById('imageModal');
    const modalClose = document.querySelector('.modal-close');
    
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });
    }
    
    if (modalClose) {
        modalClose.addEventListener('click', closeImageModal);
    }
    
    // Update counter
    updateGalleryCounter();
}

// Image Gallery Functions
function changeMainImage(imageSrc, thumbnailElement, index) {
    const mainImage = document.getElementById('mainPortfolioImage');
    if (mainImage) {
        mainImage.src = imageSrc;
        currentImageIndex = index;
        
        // Update active thumbnail
        document.querySelectorAll('.gallery-thumbnail').forEach(thumb => {
            thumb.classList.remove('active');
        });
        thumbnailElement.classList.add('active');
        
        // Update zoom button
        const zoomBtn = document.querySelector('.zoom-btn');
        if (zoomBtn) {
            zoomBtn.setAttribute('onclick', `openImageModal('${imageSrc}')`);
        }
        
        // Update counter
        updateGalleryCounter();
    }
}

function previousImage() {
    if (galleryImages.length === 0) return;
    
    currentImageIndex = currentImageIndex > 0 ? currentImageIndex - 1 : galleryImages.length - 1;
    const newImageSrc = galleryImages[currentImageIndex];
    const thumbnailElement = document.querySelector(`[data-index="${currentImageIndex}"]`);
    
    if (thumbnailElement) {
        changeMainImage(newImageSrc, thumbnailElement, currentImageIndex);
    }
}

function nextImage() {
    if (galleryImages.length === 0) return;
    
    currentImageIndex = currentImageIndex < galleryImages.length - 1 ? currentImageIndex + 1 : 0;
    const newImageSrc = galleryImages[currentImageIndex];
    const thumbnailElement = document.querySelector(`[data-index="${currentImageIndex}"]`);
    
    if (thumbnailElement) {
        changeMainImage(newImageSrc, thumbnailElement, currentImageIndex);
    }
}

function updateGalleryCounter() {
    const currentIndexElement = document.getElementById('currentImageIndex');
    const totalImagesElement = document.getElementById('totalImages');
    
    if (currentIndexElement) {
        currentIndexElement.textContent = currentImageIndex + 1;
    }
    if (totalImagesElement) {
        totalImagesElement.textContent = galleryImages.length;
    }
}

function openImageModal(imageSrc) {
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    
    if (modal && modalImage) {
        modalImage.src = imageSrc;
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
}

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeImageModal();
    }
});

// Smooth scrolling for anchor links
document.addEventListener('DOMContentLoaded', function() {
    const links = document.querySelectorAll('a[href^="#"]');
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
</script>

@section('footer')
    @include('frontend.layouts.footer-layout.two')
@endsection
