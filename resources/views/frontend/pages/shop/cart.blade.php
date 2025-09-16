@extends('frontend.layouts.master')

@section('meta_title', $seo_setting['cart_page']['seo_title'])
@section('meta_description', $seo_setting['cart_page']['seo_description'])
@push('custom_meta')
    <meta property="og:title" content="{{ $seo_setting['cart_page']['seo_title'] }}" />
    <meta property="og:description" content="{{ $seo_setting['cart_page']['seo_description'] }}" />
    <meta property="og:image" content="{{ asset($setting?->cart_page_breadcrumb_image) }}" />
    <meta property="og:URL" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
@endpush

@section('header')
    @include('frontend.layouts.header-layout.three')
@endsection

@section('contents')
    <!-- Breadcumb -->
    <x-breadcrumb :image="$setting?->cart_page_breadcrumb_image" :title="__('My Cart')" />

    <!-- Main Area -->
    <div class="cart-wrapper space-top space-extra-bottom">
        <div class="container cart-page-content">
            @include('frontend.pages.shop.partials.cart-page-content')
        </div>
    </div>

    <!--  Marquee Area -->
    @include('frontend.partials.marquee')

@endsection

@section('footer')
    @include('frontend.layouts.footer-layout.two')
@endsection
