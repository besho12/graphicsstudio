<div class="row">
    <div class="col-70">
        <div class="shop-sort-bar">
            <div class="row justify-content-between align-items-center">
                <div class="col-sm-auto">
                    <p class="woocommerce-result-count">{{ $breadcrumb_result }}</p>
                </div>

                <div class="col-sm-auto">
                    <form class="woocommerce-ordering" method="get">
                        <select name="orderby" class="orderby" aria-label="{{ __('Shop order') }}">
                            <option value="latest" @selected(request('orderby') == 'latest')>{{ __('Sort by latest') }}</option>
                            <option value="oldest" @selected(request('orderby') == 'oldest')>{{ __('Sort by oldest') }}</option>
                            <option value="popularity" @selected(request('orderby') == 'popularity')>{{ __('Sort by popularity') }}
                            </option>
                            <option value="rating" @selected(request('orderby') == 'rating')>{{ __('Sort by average rating') }}
                            </option>
                            <option value="price" @selected(request('orderby') == 'price')>{{ __('Sort by price: low to high') }}
                            </option>
                            <option value="price-desc" @selected(request('orderby') == 'price-desc')>
                                {{ __('Sort by price: high to low') }}</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>
        <div class="row gy-60">
            @forelse ($products as $product)
                <div class="col-sm-6">
                    <div class="product-card">
                        <div class="shop-page product-img d-flex justify-content-center align-items-center">
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
                                <div class="tag left-side text-uppercase bg-success ">{{ __('New') }}</div>
                            @endif

                            <a href="javascript:;" class="wsus-wishlist-btn" data-slug="{{ $product?->slug }}">
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
            @empty
                <x-data-not-found />
            @endforelse
        </div>
        @if ($products->hasPages())
            {{ $products->onEachSide(0)->links('frontend.pagination.custom') }}
        @endif
    </div>

    <div class="col-30">
        <aside class="shop__sidebar">
            {{-- Search widget removed --}}
            <div class="sidebar__widget">
                <h4 class="sidebar__widget-title">{{ __('Categories') }}</h4>
                <div class="sidebar__cat-list">
                    <ul class="list-wrap">
                        @foreach ($categories as $category)
                            <li>

                                <input @checked(in_array($category?->slug, explode(',', request('category')))) class="form-check-input category-checkbox"
                                    type="checkbox" value="{{ $category?->slug }}" id="cat_{{ $category?->slug }}">
                                <label class="form-check-label"
                                    for="cat_{{ $category?->slug }}">{{ $category?->title }}
                                    ({{ $category?->products_count }})
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="sidebar__widget">
                <h4 class="sidebar__widget-title">{{ __('Filter by Price') }}</h4>
                <div class="widget_price_filter">
                    <div class="price_slider_wrapper">
                        <div class="price_slider"></div>
                        <div class="price_label">
                            {{ __('Price') }} : <span class="from"></span> — <span class="to"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sidebar__widget">
                <h4 class="sidebar__widget-title">{{ __('Filter by Rating') }}</h4>
                <div class="sidebar__cat-list">
                    <ul class="list-wrap">
                        <li>
                            <input @checked(in_array(5, explode(',', request('rating')))) class="form-check-input rating-checkbox"type="checkbox"
                                value="5" id="rating_5">
                            <label class="form-check-label"for="rating_5">
                                <i class="fas fa-star" aria-hidden="true"></i>
                                {{ __('5 Star') }}
                            </label>
                        </li>
                        <li>
                            <input @checked(in_array(4, explode(',', request('rating')))) class="form-check-input rating-checkbox"type="checkbox"
                                value="4" id="rating_4">
                            <label class="form-check-label"for="rating_4">
                                <i class="fas fa-star" aria-hidden="true"></i>
                                {{ __('4 Star') }}
                            </label>
                        </li>
                        <li>
                            <input @checked(in_array(3, explode(',', request('rating')))) class="form-check-input rating-checkbox"type="checkbox"
                                value="3" id="rating_3">
                            <label class="form-check-label"for="rating_3">
                                <i class="fas fa-star" aria-hidden="true"></i>
                                {{ __('3 Star') }}
                            </label>
                        </li>
                        <li>
                            <input @checked(in_array(2, explode(',', request('rating'))))
                                class="form-check-input rating-checkbox"type="checkbox" value="2"
                                id="rating_2">
                            <label class="form-check-label"for="rating_2">
                                <i class="fas fa-star" aria-hidden="true"></i>
                                {{ __('2 Star') }}
                            </label>
                        </li>
                        <li>
                            <input @checked(in_array(1, explode(',', request('rating'))))
                                class="form-check-input rating-checkbox"type="checkbox" value="1"
                                id="rating_1">
                            <label class="form-check-label"for="rating_1">
                                <i class="fas fa-star" aria-hidden="true"></i>
                                {{ __('1 Star') }}
                            </label>
                        </li>
                    </ul>
                </div>
            </div>
            @if ($topTags)
                <div class="sidebar__widget">
                    <h4 class="sidebar__widget-title">{{ __('Tags') }}</h4>
                    <div class="sidebar__tag-list">
                        <ul class="list-wrap filter-by-tag">
                            @foreach ($topTags as $key => $tag)
                                <li class="text-capitalize"><a href="javascript:;"
                                        data-tag="{{ $key }}">{{ $key }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            <div class="sidebar__widget">
                <h4 class="sidebar__widget-title mb-20">{{ __('Share') }}</h4>
                <div class="social-btn style3">
                    <a class="share-social" href="{{ route('shop') }}" data-platform="facebook">
                        <span class="link-effect">
                            <span class="effect-1"><i class="fab fa-facebook"></i></span>
                            <span class="effect-1"><i class="fab fa-facebook"></i></span>
                        </span>
                    </a>
                    <a class="share-social" href="{{ route('shop') }}" data-platform="linkedin">
                        <span class="link-effect">
                            <span class="effect-1"><i class="fab fa-linkedin"></i></span>
                            <span class="effect-1"><i class="fab fa-linkedin"></i></span>
                        </span>
                    </a>
                    <a class="share-social" href="{{ route('shop') }}" data-platform="twitter">
                        <span class="link-effect">
                            <span class="effect-1"><i class="fab fa-twitter"></i></span>
                            <span class="effect-1"><i class="fab fa-twitter"></i></span>
                        </span>
                    </a>
                </div>
            </div>
        </aside>
    </div>
</div>
