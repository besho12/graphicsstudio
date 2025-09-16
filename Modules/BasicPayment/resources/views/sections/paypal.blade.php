<div class="tab-pane fade" id="paypal_payment_tab" role="tabpanel">
    <form action="{{ route('admin.update-paypal') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <x-admin.form-select id="paypal_account_mode" name="paypal_account_mode"
                        label="{{ __('Account Mode') }}" class="form-select">
                        <x-admin.select-option :selected="$basic_payment->paypal_account_mode == 'live'" value="live" text="{{ __('Live') }}" />
                        <x-admin.select-option :selected="$basic_payment->paypal_account_mode == 'sandbox'" value="sandbox" text="{{ __('Sandbox') }}" />
                    </x-admin.form-select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <x-admin.form-input id="paypal_charge" name="paypal_charge" label="{{ __('Gateway charge') }}(%)"
                        value="{{ $basic_payment->paypal_charge }}" required="true" />
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    @if (config('app.app_mode') == 'DEMO')
                        <x-admin.form-input id="paypal_client_id" name="paypal_client_id" label="{{ __('Client ID') }}"
                            value="PAYPAL-TEST-CLIENT98934343-343-ID" required="true" />
                    @else
                        <x-admin.form-input id="paypal_client_id" name="paypal_client_id" label="{{ __('Client ID') }}"
                            value="{{ $basic_payment->paypal_client_id }}" required="true" />
                    @endif
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    @if (config('app.app_mode') == 'DEMO')
                        <x-admin.form-input id="paypal_secret_key" name="paypal_secret_key"
                            label="{{ __('Secret Key') }}" value="PAYPAL-TEST-398439483-SECRET-KEY" required="true" />
                    @else
                        <x-admin.form-input id="paypal_secret_key" name="paypal_secret_key"
                            label="{{ __('Secret Key') }}" value="{{ $basic_payment->paypal_secret_key }}"
                            required="true" />
                    @endif
                </div>
            </div>

        </div>

        <div class="form-group">
            <x-admin.form-image-preview recommended="200X110" div_id="paypal_image_preview" label_id="paypal_image_label"
                input_id="paypal_image_upload" :image="$basic_payment->paypal_image" name="paypal_image" label="{{ __('Existing Image') }}"
                button_label="{{ __('Update Image') }}" required="0" />
        </div>
        <div class="form-group">
            <x-admin.form-switch name="paypal_status" label="{{ __('Status') }}" active_value="active"
                inactive_value="inactive" :checked="$basic_payment->paypal_status == 'active'" />
        </div>

        <x-admin.update-button :text="__('Update')" />
    </form>
</div>