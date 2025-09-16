@if ($setting?->is_shop)
    <button type="button" class="header-cart sideMenuToggler"><img src="{{ asset('frontend/images/shopping-cart.svg') }}"
            alt="{{ __('Cart') }}">
        <span class="link-effect header-cart-text">
            <span class="effect-1 cart-count">{{ __('Cart') }} <span>({{ Gloudemans\Shoppingcart\Facades\Cart::content()->count() }})</span></span>
            <span class="effect-1 cart-count">{{ __('Cart') }} <span>({{ Gloudemans\Shoppingcart\Facades\Cart::content()->count() }})</span></span>
        </span>
    </button>
@endif
