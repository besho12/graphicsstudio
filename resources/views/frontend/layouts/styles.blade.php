<!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/magnific-popup.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/slick.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/imageRevealHover.css') }}">
    <link rel="stylesheet" href="{{ asset('global/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/cookie-consent.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.min.css?version=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/custom.css?version=1.0.0') }}?v={{ $setting?->version }}">
    @if (session()->has('text_direction') && session()->get('text_direction') == 'rtl')
    <link rel="stylesheet" href="{{ asset('frontend/css/rtl.css') }}?v={{ $setting?->version }}">
    @endif
<style>
:root {--theme-color: {{ $setting?->primary_color ?? '#E3FF04' }};--title-color: {{ $setting?->secondary_color ?? '#0A0C00' }};--body-color: {{ $setting?->secondary_color ?? '#0A0C00' }};}
@if ($setting?->tawk_status == 'active')
.scroll-top {bottom: 90px;}
@endif
</style>
@stack('css')
