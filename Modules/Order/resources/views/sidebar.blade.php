<li
    class="nav-item dropdown {{ isRoute(['admin.orders', 'admin.order', 'admin.order*', 'admin.pending-payment', 'admin.rejected-payment', 'admin.pending-orders', 'admin.shipping-method.*'], 'active') }}">
    <a href="javascript:;" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-shopping-bag"></i>
        <span>{{ __('Manage Order') }} </span>

    </a>
    <ul class="dropdown-menu">
        @adminCan('order.management')
        <li class="{{ isRoute('admin.orders', 'active') }}"><a class="nav-link"
                href="{{ route('admin.orders') }}">{{ __('Order History') }}</a></li>

        <li class="{{ isRoute('admin.pending-orders', 'active') }}"><a class="nav-link"
                href="{{ route('admin.pending-orders') }}">{{ __('Pending Order') }}</a></li>


        <li class="{{ isRoute('admin.pending-payment', 'active') }}"><a class="nav-link"
                href="{{ route('admin.pending-payment') }}">{{ __('Pending Payment') }}</a></li>

        <li class="{{ isRoute('admin.rejected-payment', 'active') }}"><a class="nav-link"
                href="{{ route('admin.rejected-payment') }}">{{ __('Rejected Payment') }}</a></li>
        @endadminCan
        @adminCan('shipping.method.view')
            <li class="{{ isRoute('admin.shipping-method.*', 'active') }}"><a class="nav-link"
                    href="{{ route('admin.shipping-method.index', ['code' => getSessionLanguage()]) }}">{{ __('Shipping Type') }}</a>
            </li>
        @endadminCan
    </ul>
</li>
