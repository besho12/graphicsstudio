<div class="sidemenu-wrapper">
    <div class="sidemenu-content">
        <button class="closeButton sideMenuCls"><img src="{{ asset('frontend/images/close.svg') }}"></button>
        <div class="widget woocommerce widget_shopping_cart">
            <h3 class="widget_title">{{__('Shopping cart')}}</h3>
            <div class="widget_shopping_cart_content cart-content">
                @include('frontend.pages.shop.partials.cart-sidebar')
            </div>
        </div>
    </div>
</div>