@extends('frontend.layouts.master')

@section('meta_title', $seo_setting['shop_page']['seo_title'])
@section('meta_description', $seo_setting['shop_page']['seo_description'])
@push('custom_meta')
    <meta property="og:title" content="{{ $seo_setting['shop_page']['seo_title'] }}" />
    <meta property="og:description" content="{{ $seo_setting['shop_page']['seo_description'] }}" />
    <meta property="og:image" content="{{ asset($setting?->shop_page_breadcrumb_image) }}" />
    <meta property="og:URL" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
@endpush

@section('header')
    @include('frontend.layouts.header-layout.three')
@endsection

@section('contents')
    <!-- Breadcumb -->
    <x-breadcrumb :image="$setting?->shop_page_breadcrumb_image" :title="__('Shop')" />

    <!-- Main Area -->
    <section class="shop__area space top-baseline">
        <div class="container">
            <div class="shop__inner-wrap">
                {{-- dynamic content will go here via ajax --}}
            </div>
        </div>
    </section>


    <!--  Marquee Area -->
    @include('frontend.partials.marquee')

@endsection

@section('footer')
    @include('frontend.layouts.footer-layout.two')
@endsection

@push('js')
    <script src="{{ asset('frontend/js/shop.js') }}"></script>
@endpush
