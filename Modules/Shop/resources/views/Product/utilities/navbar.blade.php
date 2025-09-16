<div class="section-body row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-center">
                <a href="{{ route('admin.product.edit', [
                    'product' => $product->id,
                    'code' => allLanguages()->first()->code,
                ]) }}"
                    class="m-1 btn {{ Route::is('admin.product.edit') ? 'btn-success' : 'btn-info' }}">{{ __('Manage Product') }}</a>
                <a href="{{ route('admin.product.gallery', $product->id) }}"
                    class="m-1 btn {{ Route::is('admin.product.gallery') ? 'btn-success' : 'btn-info' }}">{{ __('Manage Gallery') }}</a>
            </div>
        </div>
    </div>
</div>