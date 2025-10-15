<div class="tab-pane fade" id="footer_tab" role="tabpanel">
    <form action="{{ route('admin.update-footer-settings') }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <x-admin.form-textarea id="company_description" name="company_description" 
                label="{{ __('Company Description') }}"
                placeholder="{{ __('Enter Company Description') }}" 
                value="{{ $setting->company_description }}" 
                maxlength="500" />
        </div>
        
        <div class="form-group">
            <x-admin.form-textarea id="copyright_text" name="copyright_text" 
                label="{{ __('Copyright Text') }}"
                placeholder="{{ __('Enter Copyright Text') }}" 
                value="{{ $setting->copyright_text }}" 
                maxlength="1000" />
        </div>
        
        <x-admin.update-button :text="__('Update')" />
    </form>
</div>