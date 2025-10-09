<!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Vite Optimized Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/magnific-popup.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/slick.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/imageRevealHover.css') }}">
    <link rel="stylesheet" href="{{ asset('global/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/cookie-consent.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.min.css?version=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/custom.css?version=1.0.0') }}?v={{ $setting?->version }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/scroll-performance.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/css-marquee.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/simple-marquee.css') }}">
    
    <!-- Simple Project Cards CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/simple-project-cards.css') }}">
    
    <!-- Hero Title Override CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/hero-title-override.css') }}">
    
    <!-- Hero Mobile Fix CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/hero-mobile-fix.css') }}">
    
    <!-- Hero Responsive Fix CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/hero-responsive-fix.css') }}">
    
    <!-- Hero Image Fix CSS - Complete Solution -->
    <link rel="stylesheet" href="{{ asset('frontend/css/hero-image-fix.css') }}">
    
    <!-- Hero Mobile Complete Fix CSS - Final Solution for Mobile Display Issues -->
    <link rel="stylesheet" href="{{ asset('frontend/css/hero-mobile-complete-fix.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/hero-emergency-fix.css') }}">
    
    <!-- Hero Mobile Text Position Fix - Move hero text higher on mobile devices -->
    <link rel="stylesheet" href="{{ asset('frontend/css/hero-mobile-text-position-fix.css') }}">
    
    <!-- Hero Button Redesign - Modern & Responsive -->
    <link rel="stylesheet" href="{{ asset('frontend/css/hero-button-redesign.css') }}">
    
    <!-- Service Action Button Mobile Fix - Improve padding and visibility on mobile -->
    <link rel="stylesheet" href="{{ asset('frontend/css/service-action-btn-mobile-fix.css') }}">
    
    <!-- Feature Card Button Redesign - Modern Blue Theme -->
    <link rel="stylesheet" href="{{ asset('frontend/css/feature-button-redesign.css') }}">
    
    <!-- Optimized Projects CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/optimized-projects.css') }}">
    
    <!-- Service Page Modern Design CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/service-page.css') }}">

    <!-- Modern Footer CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/modern-footer.css') }}">
    <!-- Footer Layout 2 Modern CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/footer-layout2-organized.css') }}">
    
    <!-- FADA.A Navigation CSS - Exact Replica -->
    <link rel="stylesheet" href="{{ asset('frontend/css/fada-nav.css') }}">

    <!-- Dark Blue Mobile Menu CSS - Theme 3 Mobile Navigation -->
    <link rel="stylesheet" href="{{ asset('frontend/css/dark-blue-mobile-menu.css') }}">

    <!-- Hero Rotation Fix CSS - Disables unwanted rotation animations -->
    <link rel="stylesheet" href="{{ asset('frontend/css/hero-rotation-fix.css') }}">

    <!-- Modern Language Switcher CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/language-switcher.css') }}">

    @if (session()->has('text_direction') && session()->get('text_direction') == 'rtl')
    <link rel="stylesheet" href="{{ asset('frontend/css/rtl.css') }}"?v={{ $setting?->version }}>
    @endif
<style>
:root {--theme-color: {{ $setting?->primary_color ?? '#E3FF04' }};--title-color: {{ $setting?->secondary_color ?? '#0A0C00' }};--body-color: {{ $setting?->secondary_color ?? '#0A0C00' }};}
@if ($setting?->tawk_status == 'active')
.scroll-top {bottom: 90px;}
@endif
</style>
@stack('css')
