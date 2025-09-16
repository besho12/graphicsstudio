@extends('frontend.layouts.master')

@section('meta_title', __('Digital Product') . ' || ' . $setting->app_name)

@section('header')
    @include('frontend.layouts.header-layout.three')
@endsection

@section('contents')
    <!-- Breadcumb Area -->
    <x-breadcrumb :title="__('Digital Product')" />

    <!--  Dashboard Area -->
    <section class="wsus__dashboard_profile wsus__dashboard">
        <div class="container">
            <div class="row">
                <!--  Sidebar Area -->
                @include('frontend.profile.partials.sidebar')
                <!--  Main Content Area -->
                <div class="col-lg-8 col-xl-9 ">
                    <div class="wsus__dashboard_main_contant wishlist-content">
                        <h4>{{ __('Digital Product') }}</h4>
                        <div class="wsus__dashboard_wishlist">
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <th class="image text-center">
                                                        {{ __('Image') }}
                                                    </th>
                                                    <th class="details text-center">
                                                        {{ __('Details') }}
                                                    </th>
                                                    <th class="status text-center">
                                                        {{ __('Download') }}
                                                    </th>
                                                </tr>
                                                @forelse ($digital_products as $orderProduct)
                                                    <tr>
                                                        <td class="image">
                                                            <a href="{{ route('single.product', $orderProduct?->product?->slug) }}">
                                                                <img src="{{ asset($orderProduct?->product?->image) }}"
                                                                    alt="{{ $orderProduct?->product?->title }}" class="img-fluid w-100">
                                                            </a>
                                                        </td>
                                                        <td class="details text-center">
                                                            <h5>{{ $orderProduct?->product?->title }}</h5>
                                                            <p class="rating">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    @if ($i <= floor($orderProduct?->product?->average_rating))
                                                                        <i class="fas fa-solid fa-star"></i>
                                                                    @elseif ($i - 0.5 <= $orderProduct?->product?->average_rating)
                                                                        <i class="fas fa-solid fa-star-half-alt"></i>
                                                                    @else
                                                                        <i class="far fa-star"></i>
                                                                    @endif
                                                                @endfor
                                                                <span>({{ $orderProduct?->product?->reviews_count }}
                                                                    {{ __('Reviews') }})</span>
                                                            </p>
                                                            <h6>{{ currency($orderProduct?->product?->price) }}</h6>
                                                        </td>
                                                        <td class="status text-center">
                                                            <a class="btn style2 py-2 px-3" href="{{ route('user.digital.product-download', $orderProduct?->product?->slug) }}">{{__('Download')}} <i
                                                                class="fa fa-download"></i></a></a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5">
                                                            <x-data-not-found />
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($digital_products->hasPages())
                            {{ $digital_products->onEachSide(0)->links('frontend.pagination.custom') }}
                        @endif

                    </div>
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
