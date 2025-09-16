@adminCan('product.category.management')
   <li class="{{ isRoute('admin.product.category.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.product.category.index') }}">
            {{ __('Category List') }}
        </a>
    </li> 
@endadminCan
@adminCan('product.management')
    <li
        class="{{ isRoute(['admin.product.index', 'admin.product.edit', 'admin.product.create', 'admin.product.gallery']) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.product.index') }}">
            {{ __('Product List') }}
        </a>
    </li>
@endadminCan
@adminCan('product.review.management')
    <li class="{{ isRoute('admin.product-review.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.product-review.index') }}">
                {{ __('Product Reviews') }}
            </a>
        </li>
@endadminCan
