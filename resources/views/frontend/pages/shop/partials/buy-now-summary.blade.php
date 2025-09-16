@php
$payable_amount = $total_price * $qty;
@endphp
<table class="cart_table mb-20">
    <thead>
        <tr>
            <th class="cart-col-productname text-uppercase">{{ __('Product') }}</th>
            <th class="cart-col-total text-uppercase">{{ __('Sub Total') }}</th>
        </tr>
    </thead>
    <tbody>
        <tr class="cart_item">
            <td data-title="Name">
                <a class="cart-productname"
                    href="{{ $product?->slug ? route('single.product', $product->slug) : 'javascript:;' }}">
                    <img class="cart-product-img" src="{{asset($product->image)}}" alt="{{ $product?->title }}"> 
                    {{ $product?->title }}
                    <span>x{{$qty}}</span></a>
            </td>
            <td data-title="Price">
                <span class="amount"><bdi>{{ currency($payable_amount) }}</bdi></span>
            </td>
        </tr>
    </tbody>
    <tfoot class="checkout-ordertable">
        @if (session()->has('discount'))
            <tr class="cart-subtotal text-uppercase">
                <th>{{ __('Discount') }}</th>
                <td data-title="Discount"><span class="woocommerce-Price-amount amount"><bdi><span
                                class="woocommerce-Price-currencySymbol">{{ currency(totalAmount($payable_amount)?->discount) }}
                                (-)</bdi></span></td>
            </tr>
        @endif
        @if ($setting?->tax_rate)
            <tr class="cart-subtotal text-uppercase">
                <th>{{ __('Tax') }}</th>
                <td data-title="Tax"><span class="woocommerce-Price-amount amount"><bdi><span
                                class="woocommerce-Price-currencySymbol">{{ currency(totalAmount($payable_amount)?->tax) }}</bdi></span>
                </td>
            </tr>
        @endif
        @if ($setting?->is_delivery_charge && $product->type == Modules\Shop\app\Models\Product::PHYSICAL_TYPE)
            <tr class="cart-subtotal text-uppercase">
                <th>{{ __('Delivery') }}</th>
                <td data-title="Delivery"><span class="woocommerce-Price-amount amount"><bdi><span
                                class="woocommerce-Price-currencySymbol">{{ session('delivery_charge', 0) ? currency(session('delivery_charge', 0)) : __('Free') }}</bdi></span>
                </td>
            </tr>
        @endif

        <tr class="order-total text-uppercase">
            <th>{{ __('Total') }}</th>
            <td data-title="Total"><strong><span class="woocommerce-Price-amount amount"><bdi><span
                                class="woocommerce-Price-currencySymbol">{{ currency(totalAmount($payable_amount)?->total + session('delivery_charge', 0)) }}</bdi></span></strong>
            </td>
        </tr>
    </tfoot>
</table>

@php
$payable_amount = totalAmount($payable_amount)?->total + session('delivery_charge', 0);
@endphp
@if ($payable_amount > 0)
<div class="border-top border-dark pt-3">
    <h5>{{ __('Payable With Charge') }}</h5>
    @php
        $currency = getSessionCurrency();
    @endphp

    @foreach ($activeGateways as $gatewayKey => $gatewayDetails)
        @if ($paymentService->isCurrencySupported($gatewayKey))
            @php
                $payableDetails = $paymentService->getPayableAmount(
                    $gatewayKey,
                    $payable_amount,
                );
            @endphp

            <p class="mb-1 d-flex justify-content-between">
                <strong>{{ $gatewayDetails['name'] }}:</strong>
                <span>{{ $payableDetails->payable_with_charge }}
                    {{ $currency }}</span>
            </p>
        @endif
    @endforeach
</div>
@endif