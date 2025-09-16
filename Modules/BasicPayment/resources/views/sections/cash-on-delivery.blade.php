<div class="tab-pane fade" id="cash_on_delivery_tab" role="tabpanel">
    <form action="{{ route('admin.update-cash-on-delivery-payment') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <x-admin.form-image-preview div_id="cash_on_delivery_image_preview" label_id="cash_on_delivery_image_label"
                input_id="cash_on_delivery_image_upload" :image="$basic_payment?->cash_on_delivery_image " name="cash_on_delivery_image" label="{{ __('Existing Image') }}"
                button_label="{{ __('Update Image') }}" required="0"/>
        </div>
        <div class="form-group">
            <x-admin.form-switch name="bank_status" label="{{ __('Status') }}" active_value="active"
                inactive_value="inactive" :checked="$basic_payment?->cash_on_delivery_status  == 'active'" />
        </div>
        <x-admin.update-button :text="__('Update')" />
    </form>
</div>
