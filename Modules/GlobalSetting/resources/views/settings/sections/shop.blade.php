<div class="tab-pane fade" id="shop_tab" role="tabpanel">
    <form action="{{ route('admin.update-shop-setting') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <x-admin.form-switch name="is_shop" label="{{ __('Shop') }}" :checked="$setting?->is_shop == '1'" />
        </div>
        <div class="form-group">
            <x-admin.form-switch name="is_delivery_charge" label="{{ __('Delivery Charge') }}" :checked="$setting?->is_delivery_charge == '1'" />
        </div>
        <div class="form-group">
            <x-admin.form-input type="number" id="tax_rate" name="tax_rate" label="{{ __('Tax Rate') }}"
                value="{{ $setting?->tax_rate }}" />
        </div>

        <x-admin.update-button :text="__('Update')" />

    </form>
</div>
