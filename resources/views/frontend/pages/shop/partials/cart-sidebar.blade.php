<ul class="woocommerce-mini-cart cart_list product_list_widget ">
    @forelse (Cart::content() as $item)
        <li class="woocommerce-mini-cart-item mini_cart_item">
            <a href="javascript:;" data-rowid="{{ $item?->rowId }}"
                class="remove remove_from_cart_button"><i class="fas fa-times"></i></a>
            <a href="{{ $item?->options?->slug ? route('single.product', $item?->options?->slug) : 'javascript:;' }}"><img
                    src="{{ asset($item?->options?->image) }}" alt="{{ $item?->name }}">{{ $item?->name }}</a>
            <span class="wsus-white-color d-block">
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= floor($item?->options?->average_rating))
                        <i class="fas fa-solid fa-star"></i>
                    @elseif ($i - 0.5 <= $item?->options?->average_rating)
                        <i class="fas fa-solid fa-star-half-alt"></i>
                    @else
                        <i class="far fa-star"></i>
                    @endif
                @endfor
            </span>
            <span class="woocommerce-Price-amount amount">
                @if ($item?->options?->sale_price)
                    <span><del class="me-2">{{ currency($item?->options?->regular_price) }}</del>{{ currency($item?->price) }}</span>
                @else
                    <span>{{ currency($item?->price) }}</span>
                @endif
            </span>
            <span class="quantity mt-0">{{ __('Quantity') }}: {{ $item?->qty }}</span>
        </li>
    @empty
        <li class="woocommerce-mini-cart-item mini_cart_item p-0">
            <div class="d-flex flex-column justify-content-center align-items-center">
                <img class="mb-4 position-static" src="{{ asset('frontend/images/empty-cart.png') }}" alt="{{__('Cart is empty')}}">
                <h4 class="wsus-white-color">{{ __('Cart is empty') }}</h4>
                <p class="wsus-white-color">
                    {{ __('Please add some product in your cart.') }}
                </p>
            </div>
        </li>
    @endforelse
</ul>
<p class="woocommerce-mini-cart__total total">
    <strong class="text-uppercase">{{ __('Sub Total') }}</strong>
    <span class="woocommerce-Price-amount amount">{{ currency(Cart::subtotal()) }}</span>
</p>
<p class="woocommerce-mini-cart__buttons buttons btn-wrap justify-content-between">
    <a href="{{ route('cart') }}" class="btn style-white wc-forward">
        <span class="link-effect text-uppercase">
            <span class="effect-1">{{ __('View Cart') }}</span>
            <span class="effect-1">{{ __('View Cart') }}</span>
        </span>
    </a>
    <a href="{{ route('user.checkout') }}" class="btn style2 wc-forward">
        <span class="link-effect text-uppercase">
            <span class="effect-1">{{ __('Checkout') }}</span>
            <span class="effect-1">{{ __('Checkout') }}</span>
        </span>
    </a>
</p>
