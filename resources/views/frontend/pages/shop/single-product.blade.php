@extends('frontend.layouts.master')

@section('meta_title', $product?->title . ' || ' . $setting->app_name)
@section('meta_description', $product?->seo_description)

@push('custom_meta')
    <meta property="og:title" content="{{ $product?->seo_title }}" />
    <meta property="og:description" content="{{ $product?->seo_description }}" />
    <meta property="og:image" content="{{ asset($product?->image) }}" />
    <meta property="og:URL" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
@endpush

@section('header')
    @include('frontend.layouts.header-layout.three')
@endsection

@section('contents')
    <!-- breadcrumb-area -->
    <x-breadcrumb-two :title="$product?->title" :links="[['url' => route('home'), 'text' => __('Home')], ['url' => route('shop'), 'text' => __('Shop')]]" />

    <!-- Main Area -->
    <section class="shop__area space">
        <div class="container">
            <div class="row gx-60 gy-60">
                <div class="col-xl-6">
                    <div class="product-big-img">
                        <div class="global-carousel product-thumb-slider" data-slide-show="1"
                            data-asnavfor=".product-small-img" data-loop="true">
                            @forelse ($product?->images as $image)
                                <div class="slide">
                                    <div class="img"><img src="{{ asset($image?->image) }}" alt="{{ $product?->title }}">
                                    </div>
                                </div>
                            @empty
                                <div class="slide">
                                    <div class="img"><img src="{{ asset($product?->image) }}"
                                            alt="{{ $product?->title }}">
                                    </div>
                                </div>
                            @endforelse
                        </div>
                        @if ($product?->sale_price)
                            <div class="tag text-uppercase">{{ __('Sale') }}</div>
                        @endif
                    </div>
                    <div class="row global-carousel product-small-img" data-slide-show="3" data-md-slide-show="3"
                        data-sm-slide-show="3" data-xs-slide-show="2" data-center-mode="true"
                        data-asnavfor=".product-thumb-slider" data-loop="true">
                        @forelse ($product?->images as $image)
                            <div class="col-lg-4 slide-thumb">
                                <div class="img"><img src="{{ asset($image?->image) }}"alt="{{ $product?->title }}">
                                </div>
                            </div>
                        @empty
                            <div class="col-lg-4 slide-thumb">
                                <div class="img"><img src="{{ asset($product?->image) }}"alt="{{ $product?->title }}">
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="product-about">
                        <h2 class="product-title">{{ $product?->title }}</h2>

                        <div class="product-rating">
                            <span>
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= floor($product?->average_rating))
                                        <i class="fas fa-solid fa-star"></i>
                                    @elseif ($i - 0.5 <= $product?->average_rating)
                                        <i class="fas fa-solid fa-star-half-alt"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </span>
                            <span class="woocommerce-review-link">(<span
                                    class="count">{{ $product?->reviews_count }}</span>
                                {{ __('customer reviews') }})</span>
                        </div>
                        @if ($product?->sale_price)
                            <p class="price">
                                <del>{{ currency($product?->price) }}</del>{{ currency($product?->sale_price) }}
                            </p>
                        @else
                            <p class="price">{{ currency($product?->price) }}</p>
                        @endif
                        <p class="text">{{ $product?->short_description }}</p>
                        <div class="actions">
                            @php
                                $is_digital = $product?->type == Modules\Shop\app\Models\Product::DIGITAL_TYPE;
                            @endphp

                            @if ($is_digital && checkPurchased($product->id))
                                <a href="{{ route('user.digital.product-download', $product?->slug) }}" class="btn style2">
                                    <span class="link-effect">
                                        <span class="effect-1">{{ __('Download') }}</span>
                                        <span class="effect-1">{{ __('Download') }}</span>
                                    </span>
                                </a>
                                <a href="javascript:;" class="wsus-wishlist-btn" data-slug="{{ $product?->slug }}">
                                    <i class="{{ $product?->favorited_by_client ? 'fas' : 'far' }} fa-heart"></i>
                                </a>
                            @else
                                @if ($product?->qty)
                                    <div class="quantity {{ $is_digital ? 'd-none' : '' }}">
                                        <span class="title">{{ __('Quantity') }}</span>
                                        <button class="quantity-minus qty-btn"><i class="fas fa-minus"></i></button>
                                        <input type="number" class="qty-input quantity-input-value" step="1"
                                            min="1" max="100" name="quantity" value="1" title="Qty">
                                        <button class="quantity-plus qty-btn"><i class="fas fa-plus"></i></button>
                                    </div>
                                    <a href="javascript:;" class="btn add-to-cart-btn" data-slug="{{ $product?->slug }}">
                                        <span class="link-effect">
                                            <span class="effect-1">{{ __('Add To Cart') }}</span>
                                            <span class="effect-1">{{ __('Add To Cart') }}</span>
                                        </span>
                                    </a>
                                    <a href="javascript:;" class="btn style2 buy-now-btn"
                                        data-url="{{ route('user.buy.now', ['slug' => $product?->slug]) }}">
                                        <span class="link-effect">
                                            <span class="effect-1">{{ __('Buy Now') }}</span>
                                            <span class="effect-1">{{ __('Buy Now') }}</span>
                                        </span>
                                    </a>
                                    <a href="javascript:;" class="wsus-wishlist-btn" data-slug="{{ $product?->slug }}">
                                        <i class="{{ $product?->favorited_by_client ? 'fas' : 'far' }} fa-heart"></i>
                                    </a>
                                @else
                                    <div class="quantity bg-danger">
                                        <span class="wsus-white-color">{{ __('Out of stock') }}</span>
                                    </div>
                                @endif
                            @endif
                        </div>
                        <div class="product_meta">
                            <span class="sku_wrapper">{{ __('SKU') }}: <span
                                    class="sku">{{ $product?->sku }}</span></span>
                            <span class="posted_in">{{ __('Category') }}: <a
                                    href="{{ route('shop', ['category' => $product?->category?->slug]) }}"
                                    rel="tag">{{ $product?->category?->title }}</a></span>
                            <span>{{ __('Tags') }}: <span>{!! $tagString !!}</span></span>
                        </div>
                        <div class="sidebar__widget mt-5">
                            <h4 class="sidebar__widget-title mb-20">{{ __('Share') }}</h4>
                            <div class="social-btn style3">
                                <a class="share-social" href="{{ route('single.product', $product?->slug) }}"
                                    data-platform="facebook">
                                    <span class="link-effect">
                                        <span class="effect-1"><i class="fab fa-facebook"></i></span>
                                        <span class="effect-1"><i class="fab fa-facebook"></i></span>
                                    </span>
                                </a>
                                <a class="share-social" href="{{ route('single.product', $product?->slug) }}"
                                    data-platform="linkedin">
                                    <span class="link-effect">
                                        <span class="effect-1"><i class="fab fa-linkedin"></i></span>
                                        <span class="effect-1"><i class="fab fa-linkedin"></i></span>
                                    </span>
                                </a>
                                <a class="share-social" href="{{ route('single.product', $product?->slug) }}"
                                    data-platform="twitter">
                                    <span class="link-effect">
                                        <span class="effect-1"><i class="fab fa-twitter"></i></span>
                                        <span class="effect-1"><i class="fab fa-twitter"></i></span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="nav product-tab-style1" id="productTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link th-btn active" id="description-tab" data-bs-toggle="tab" href="#description"
                        role="tab" aria-controls="description" aria-selected="true">{{ __('Description') }}</a>
                </li>
                @if (!empty($product?->additional_description))
                    <li class="nav-item" role="presentation">
                        <a class="nav-link th-btn" id="info-tab" data-bs-toggle="tab" href="#info" role="tab"
                            aria-controls="info" aria-selected="false">{{ __('Information') }}</a>
                    </li>
                @endif
                <li class="nav-item" role="presentation">
                    <a class="nav-link th-btn" id="reviews-tab" data-bs-toggle="tab" href="#reviews" role="tab"
                        aria-controls="reviews" aria-selected="false">{{ __('Reviews') }}
                        ({{ $product?->reviews_count }})</a>
                </li>

            </ul>
            <div class="tab-content" id="productTabContent">
                <div class="tab-pane fade details-text show active" id="description" role="tabpanel"
                    aria-labelledby="description-tab">
                    {!! clean($product?->description) !!}
                </div>
                <div class="tab-pane fade" id="info" role="tabpanel" aria-labelledby="info-tab">
                    {!! clean($product->additional_description) !!}
                </div>
                <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                    <div class="woocommerce-Reviews mb-25">
                        <div class="comments-wrap">
                            <div class="latest-comments">
                                <ul class="list-wrap">
                                    @forelse ($product->reviews as $review)
                                        <li>
                                            <div class="comments-box">
                                                <div class="comments-avatar">
                                                    <img src="{{ asset($review?->user?->image ?? $setting?->default_avatar) }}"
                                                        alt="{{ $review?->name }}">
                                                </div>
                                                <div class="comments-text">
                                                    <div class="avatar-name">
                                                        <span
                                                            class="date">{{ formattedDate($review?->created_at) }}</span>
                                                        <span>
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                @if ($i <= floor($review?->rating))
                                                                    <i class="fas fa-solid fa-star"></i>
                                                                @elseif ($i - 0.5 <= $review?->rating)
                                                                    <i class="fas fa-solid fa-star-half-alt"></i>
                                                                @else
                                                                    <i class="far fa-star"></i>
                                                                @endif
                                                            @endfor
                                                        </span>
                                                        <h6 class="name">{{ $review?->name }}</h6>
                                                    </div>
                                                    <p>{{ $review?->review }}</p>
                                                </div>
                                            </div>
                                        </li>
                                    @empty
                                        <li>
                                            <x-data-not-found />
                                        </li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                        @auth('web')
                            @if ($canReview)
                                <div class="comment-respond">
                                    <h3 class="comment-reply-title">{{ __('Leave a Review') }}</h3>
                                    <form action="{{ route('user.customers-review.store') }}" method="post"
                                        class="comment-form">
                                        <p class="comment-notes">
                                            {{ __('Leave your feedback to help us and other customers.') }}</p>
                                        @csrf
                                        <div class="row">
                                            <input type="hidden" name="slug" value="{{ $product?->slug }}">
                                            <div class="col-lg-12">
                                                <div class="form-group mb-1">
                                                    <input value="5" @checked(old('rating') == '5')
                                                        class="form-check-input" type="radio" name="rating"
                                                        id="rating5">
                                                    <label class="form-check-label" for="rating5">
                                                        <i class="fas fa-solid fa-star"></i>
                                                        <i class="fas fa-solid fa-star"></i>
                                                        <i class="fas fa-solid fa-star"></i>
                                                        <i class="fas fa-solid fa-star"></i>
                                                        <i class="fas fa-solid fa-star"></i>
                                                    </label>
                                                </div>
                                                <div class="form-group mb-1">
                                                    <input value="4" @checked(old('rating') == '4')
                                                        class="form-check-input" type="radio" name="rating"
                                                        id="rating4">
                                                    <label class="form-check-label" for="rating4">
                                                        <i class="fas fa-solid fa-star"></i>
                                                        <i class="fas fa-solid fa-star"></i>
                                                        <i class="fas fa-solid fa-star"></i>
                                                        <i class="fas fa-solid fa-star"></i>
                                                    </label>
                                                </div>
                                                <div class="form-group mb-1">
                                                    <input value="3" @checked(old('rating') == '3')
                                                        class="form-check-input" type="radio" name="rating"
                                                        id="rating3">
                                                    <label class="form-check-label" for="rating3">
                                                        <i class="fas fa-solid fa-star"></i>
                                                        <i class="fas fa-solid fa-star"></i>
                                                        <i class="fas fa-solid fa-star"></i>
                                                    </label>
                                                </div>
                                                <div class="form-group mb-1">
                                                    <input value="2" @checked(old('rating') == '2')
                                                        class="form-check-input" type="radio" name="rating"
                                                        id="rating2">
                                                    <label class="form-check-label" for="rating2">
                                                        <i class="fas fa-solid fa-star"></i>
                                                        <i class="fas fa-solid fa-star"></i>
                                                    </label>
                                                </div>
                                                <div class="form-group mb-1">
                                                    <input value="1" @checked(old('rating') == '1')
                                                        class="form-check-input" type="radio" name="rating"
                                                        id="rating1">
                                                    <label class="form-check-label" for="rating1">
                                                        <i class="fas fa-solid fa-star"></i>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <textarea name="review" placeholder="{{ __('Write Your Feedback') }}" id="contactForm"
                                                        class="form-control style-border style2"></textarea>
                                                </div>
                                            </div>
                                            @if ($setting?->recaptcha_status == 'active')
                                                <div class="col-lg-12">
                                                    <div class="g-recaptcha"
                                                        data-sitekey="{{ $setting->recaptcha_site_key }}">
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-btn col-12">
                                            <button type="submit" class="btn mt-25">
                                                <span class="link-effect text-uppercase">
                                                    <span class="effect-1">{{ __('Submit') }}</span>
                                                    <span class="effect-1">{{ __('Submit') }}</span>
                                                </span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
            @if ($relatedProducts->count())
                <div class="space-top">
                    <h3 class="fw-semibold mb-30 mt-n2">{{ __('Related Products') }}</h3>
                    <div class="row global-carousel" data-slide-show="3" data-md-slide-show="2" data-sm-slide-show="2">
                        @foreach ($relatedProducts as $product)
                            <div class="col-sm-6">
                                <div class="product-card">
                                    <div class="product-img">
                                        <img src="{{ asset($product?->image) }}" alt="{{ $product?->title }}">
                                        @if ($product?->qty)
                                            <div class="actions">
                                                <a href="javascript:;" class="btn add-to-cart-btn"
                                                    data-slug="{{ $product?->slug }}">
                                                    <span class="link-effect text-uppercase">
                                                        <span class="effect-1">{{ __('Add To Cart') }}</span>
                                                        <span class="effect-1">{{ __('Add To Cart') }}</span>
                                                    </span>
                                                </a>
                                            </div>
                                        @endif
                                        @if ($product?->qty == 0)
                                            <div class="tag text-uppercase bg-danger">{{ __('Out of stock') }}</div>
                                        @elseif ($product?->sale_price)
                                            <div class="tag text-uppercase">{{ __('Sale') }}</div>
                                        @endif

                                        @if ($product?->is_new)
                                            <div class="tag left-side text-uppercase bg-success ">{{ __('New') }}
                                            </div>
                                        @endif
                                        <a href="javascript:;" class="wsus-wishlist-btn"
                                            data-slug="{{ $product?->slug }}">
                                            <i class="{{ $product?->favorited_by_client ? 'fas' : 'far' }} fa-heart"></i>
                                        </a>
                                    </div>
                                    <div class="product-content">
                                        <h3 class="product-title"><a
                                                href="{{ route('single.product', $product?->slug) }}">{{ $product?->title }}</a>
                                        </h3>
                                        <span>
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= floor($product?->average_rating))
                                                    <i class="fas fa-solid fa-star"></i>
                                                @elseif ($i - 0.5 <= $product?->average_rating)
                                                    <i class="fas fa-solid fa-star-half-alt"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </span>
                                        @if ($product?->sale_price)
                                            <span
                                                class="price"><del>{{ currency($product?->price) }}</del>{{ currency($product?->sale_price) }}</span>
                                        @else
                                            <span class="price">{{ currency($product?->price) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </section>


    <!--  Marquee Area -->
    @include('frontend.partials.marquee')
@endsection
@section('footer')
    @include('frontend.layouts.footer-layout.two')
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            //buy now method
            $(document).on("click", ".buy-now-btn", function(e) {
                e.preventDefault();
                const isDigital = @json($is_digital);
                const url = $(this).data("url");
                window.location.href = isDigital ? `${url}` :
                    `${url}?qty=${$(".quantity-input-value").val() || 1}`;
            });
        });
    </script>
@endpush
