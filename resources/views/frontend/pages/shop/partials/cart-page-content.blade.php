@if (Cart::count())
    <form action="#" class="woocommerce-cart-form">
        <table class="cart_table">
            <thead>
                <tr>
                    <th colspan="3" class="cart-col-productname">{{ __('Product') }}</th>
                    <th class="cart-col-price">{{ __('Price') }}</th>
                    <th class="cart-col-quantity">{{ __('Quantity') }}</th>
                    <th class="cart-col-total">{{ __('Sub Total') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach (Cart::content() as $item)
                    <tr class="cart_item">
                        <td data-title="Remove">
                            <a href="javascript:;" data-rowid="{{ $item?->rowId }}" class="remove removeFromCart"
                                data-url="{{ url()->current() }}"><i class="fas fa-times"></i></a>
                        </td>
                        <td data-title="Product">
                            <a class="cart-productimage"
                                href="{{ $item?->options?->slug ? route('single.product', $item?->options?->slug) : 'javascript:;' }}"><img
                                    width="100" height="108" src="{{ asset($item?->options?->image) }}"
                                    alt="{{ $item?->name }}"></a>
                        </td>
                        <td data-title="Name">
                            <a class="cart-productname"
                                href="{{ $item?->options?->slug ? route('single.product', $item?->options?->slug) : 'javascript:;' }}">{{ $item?->name }}</a>
                        </td>
                        <td data-title="Price">
                            @if ($item?->options?->sale_price)
                                <span class="amount"><bdi><del>{{ currency($item?->options?->regular_price) }}</del>
                                        {{ currency($item?->price) }}</bdi></span>
                            @else
                                <span class="amount"><bdi>{{ currency($item?->price) }}</bdi></span>
                            @endif
                        </td>
                        <td data-title="Quantity">
                            <div class="quantity">
                                <span class="title">{{ __('Quantity') }}</span>
                                @if ($item?->options?->type == Modules\Shop\app\Models\Product::PHYSICAL_TYPE)
                                    <button type="button" class="cart-qty-minus qty-btn"
                                        data-id="{{ $item?->rowId }}"><i class="fas fa-minus"></i></button>
                                @endif
                                <input name="quantity" type="number" class="qty-input quantity-input-value"
                                    step="1" min="1" max="100" name="quantity"
                                    value="{{ $item?->qty }}" title="Qty">
                                @if ($item?->options?->type == Modules\Shop\app\Models\Product::PHYSICAL_TYPE)
                                    <button type="button" class="cart-qty-plus qty-btn"
                                        data-id="{{ $item?->rowId }}"><i class="fas fa-plus"></i></button>
                                @endif
                            </div>
                        </td>
                        <td data-title="Total">
                            <span class="amount"><bdi>{{ currency($item?->price * $item?->qty) }}</bdi></span>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </form>
    <div class="row gy-30 justify-content-between">
        <div class="col-xl-4 col-lg-6">
            <div class="cart-coupon">
                <input name="coupon" type="text" class="form-control coupon-code-input"
                    placeholder="{{ __('Coupon Code') }}">
                <button type="button" class="btn apply_coupon_btn">
                    <span class="link-effect text-uppercase">
                        <span class="effect-1">{{ __('Apply') }}</span>
                        <span class="effect-1">{{ __('Apply') }}</span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="row justify-content-end">
        <div class="col-12">
            <h3 class="fw-semibold summary-title mt-90 mb-2">{{ __('Cart Totals') }}</h3>
            <table class="cart_totals">
                <tbody>
                    <tr>
                        <td class="text-uppercase">{{ __('Sub Total') }}</td>
                        <td data-title="Cart Subtotal">
                            <span class="amount"><bdi><span>{{ currency(Cart::subtotal()) }}</bdi></span>
                        </td>
                    </tr>
                    @if (session()->has('discount'))
                        <tr>
                            <td class="text-uppercase">{{ __('Discount') }}</td>
                            <td data-title="Discount">
                                <span class="amount"><bdi><span>{{ currency(totalAmount()?->discount) }}
                                            (-)</bdi></span>
                            </td>
                        </tr>
                    @endif
                </tbody>
                <tfoot>
                    <tr class="order-total">
                        <td class="text-uppercase">{{ __('Total') }}</td>
                        <td data-title="Total">
                            <strong><span
                                    class="amount"><bdi>{{ currency(totalAmount()?->discountTotal) }}</span></strong>
                        </td>
                    </tr>
                </tfoot>
            </table>
            <div class="wc-proceed-to-checkout mb-30">
                <a href="{{ route('user.checkout') }}" class="btn">
                    <span class="link-effect text-uppercase">
                        <span class="effect-1">{{ __('Proceed To Checkout') }}</span>
                        <span class="effect-1">{{ __('Proceed To Checkout') }}</span>
                    </span>
                </a>
            </div>
        </div>
    </div>
@else
    <div class="d-flex flex-column justify-content-center align-items-center">
        <img class="mb-4 position-static" src="{{ asset('frontend/images/empty-cart.png') }}">
        <h4>{{ __('Cart is empty') }}</h4>
        <p>
            {{ __('Please add some product in your cart.') }}
        </p>
        <a href="{{ route('shop') }}" class="btn">
            <span class="link-effect text-uppercase">
                <span class="effect-1">{{ __('Continue To Shopping') }}</span>
                <span class="effect-1">{{ __('Continue To Shopping') }}</span>
            </span>
        </a>
    </div>
@endif
