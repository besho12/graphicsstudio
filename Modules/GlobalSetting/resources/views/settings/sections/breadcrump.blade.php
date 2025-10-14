<div class="tab-pane fade" id="breadcrump_img_tab" role="tabpanel">
    <form action="{{ route('admin.update-breadcrumb') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="form-group col-md-6">
                <x-admin.form-image-preview div_id="portfolio_page_breadcrumb_image_preview"
                    label_id="portfolio_page_breadcrumb_image_label" input_id="portfolio_page_breadcrumb_image_upload"
                    :image="$setting?->portfolio_page_breadcrumb_image" name="portfolio_page_breadcrumb_image" label="{{ __('Portfolio Page Breadcrumb Image') }}"
                    button_label="{{ __('Update Image') }}"  required="0"/>
                <div class="mt-2" style="background-color: #e8f4fd; border: 1px solid #bee5eb; border-radius: 6px; padding: 8px 12px; max-width: 300px;">
                    <i class="fas fa-info-circle text-info me-2"></i>
                    <small class="text-muted">{{ __('Recommended: 1920x540 pixels') }}</small>
                </div>
            </div>
            <div class="form-group col-md-6">
                <x-admin.form-image-preview div_id="service_page_breadcrumb_image_preview"
                    label_id="service_page_breadcrumb_image_label" input_id="service_page_breadcrumb_image_upload"
                    :image="$setting?->service_page_breadcrumb_image" name="service_page_breadcrumb_image" label="{{ __('Service Page Breadcrumb Image') }}"
                    button_label="{{ __('Update Image') }}"  required="0"/>
                <div class="mt-2" style="background-color: #e8f4fd; border: 1px solid #bee5eb; border-radius: 6px; padding: 8px 12px; max-width: 300px;">
                    <i class="fas fa-info-circle text-info me-2"></i>
                    <small class="text-muted">{{ __('Recommended: 1920x540 pixels') }}</small>
                </div>
            </div>
            <div class="form-group col-12">
                <x-admin.update-button :text="__('Update')" />
            </div>
        </div>
    </form>
</div>
