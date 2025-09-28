<div class="tab-pane fade" id="breadcrump_img_tab" role="tabpanel">
    <form action="{{ route('admin.update-breadcrumb') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="form-group col-md-4">
                <x-admin.form-image-preview div_id="breadcrumb_image_preview" label_id="breadcrumb_image_label"
                    input_id="breadcrumb_image_upload" :image="$setting->breadcrumb_image" name="breadcrumb_image"
                    label="{{ __('Default Breadcrumb Image') }}" button_label="{{ __('Update Image') }}" required="0" />
            </div>
            <div class="form-group col-md-4">
                <x-admin.form-image-preview div_id="contact_page_breadcrumb_image_preview"
                    label_id="contact_page_breadcrumb_image_label" input_id="contact_page_breadcrumb_image_upload"
                    :image="$setting?->contact_page_breadcrumb_image" name="contact_page_breadcrumb_image" label="{{ __('Contact Page Breadcrumb Image') }}"
                    button_label="{{ __('Update Image') }}"  required="0"/>
            </div>
            <div class="form-group col-md-4">
                <x-admin.form-image-preview div_id="team_page_breadcrumb_image_preview"
                    label_id="team_page_breadcrumb_image_label" input_id="team_page_breadcrumb_image_upload"
                    :image="$setting?->team_page_breadcrumb_image" name="team_page_breadcrumb_image" label="{{ __('Team Page Breadcrumb Image') }}"
                    button_label="{{ __('Update Image') }}"  required="0"/>
            </div>
            <div class="form-group col-md-4">
                <x-admin.form-image-preview div_id="about_page_breadcrumb_image_preview"
                    label_id="about_page_breadcrumb_image_label" input_id="about_page_breadcrumb_image_upload"
                    :image="$setting?->about_page_breadcrumb_image" name="about_page_breadcrumb_image" label="{{ __('About Page Breadcrumb Image') }}"
                    button_label="{{ __('Update Image') }}"  required="0"/>
            </div>
            <div class="form-group col-md-4">
                <x-admin.form-image-preview div_id="faq_page_breadcrumb_image_preview"
                    label_id="faq_page_breadcrumb_image_label" input_id="faq_page_breadcrumb_image_upload"
                    :image="$setting?->faq_page_breadcrumb_image" name="faq_page_breadcrumb_image" label="{{ __('FAQ Page Breadcrumb Image') }}"
                    button_label="{{ __('Update Image') }}"  required="0"/>
            </div>
            <div class="form-group col-md-4">
                <x-admin.form-image-preview div_id="pricing_page_breadcrumb_image_preview"
                    label_id="pricing_page_breadcrumb_image_label" input_id="pricing_page_breadcrumb_image_upload"
                    :image="$setting?->pricing_page_breadcrumb_image" name="pricing_page_breadcrumb_image" label="{{ __('Pricing Page Breadcrumb Image') }}"
                    button_label="{{ __('Update Image') }}"  required="0"/>
            </div>
            <div class="form-group col-md-4">
                <x-admin.form-image-preview div_id="blog_page_breadcrumb_image_preview"
                    label_id="blog_page_breadcrumb_image_label" input_id="blog_page_breadcrumb_image_upload"
                    :image="$setting?->blog_page_breadcrumb_image" name="blog_page_breadcrumb_image" label="{{ __('Blog Page Breadcrumb Image') }}"
                    button_label="{{ __('Update Image') }}"  required="0"/>
            </div>
            <div class="form-group col-md-4">
                <x-admin.form-image-preview div_id="portfolio_page_breadcrumb_image_preview"
                    label_id="portfolio_page_breadcrumb_image_label" input_id="portfolio_page_breadcrumb_image_upload"
                    :image="$setting?->portfolio_page_breadcrumb_image" name="portfolio_page_breadcrumb_image" label="{{ __('Portfolio Page Breadcrumb Image') }}"
                    button_label="{{ __('Update Image') }}"  required="0"/>
            </div>
            <div class="form-group col-md-4">
                <x-admin.form-image-preview div_id="service_page_breadcrumb_image_preview"
                    label_id="service_page_breadcrumb_image_label" input_id="service_page_breadcrumb_image_upload"
                    :image="$setting?->service_page_breadcrumb_image" name="service_page_breadcrumb_image" label="{{ __('Service Page Breadcrumb Image') }}"
                    button_label="{{ __('Update Image') }}"  required="0"/>
            </div>
            {{-- <div class="form-group col-md-4">
                <x-admin.form-image-preview div_id="shop_page_breadcrumb_image_preview"
                    label_id="shop_page_breadcrumb_image_label" input_id="shop_page_breadcrumb_image_upload"
                    :image="$setting?->shop_page_breadcrumb_image" name="shop_page_breadcrumb_image" label="{{ __('Shop Page Breadcrumb Image') }}"
                    button_label="{{ __('Update Image') }}"  required="0"/>
            </div> --}}
            {{-- <div class="form-group col-md-4">
                <x-admin.form-image-preview div_id="cart_page_breadcrumb_image_preview"
                    label_id="cart_page_breadcrumb_image_label" input_id="cart_page_breadcrumb_image_upload"
                    :image="$setting?->cart_page_breadcrumb_image" name="cart_page_breadcrumb_image" label="{{ __('Cart Page Breadcrumb Image') }}"
                    button_label="{{ __('Update Image') }}"  required="0"/>
            </div> --}}
            {{-- <div class="form-group col-md-4">
                <x-admin.form-image-preview div_id="checkout_page_breadcrumb_image_preview"
                    label_id="checkout_page_breadcrumb_image_label" input_id="checkout_page_breadcrumb_image_upload"
                    :image="$setting?->checkout_page_breadcrumb_image" name="checkout_page_breadcrumb_image" label="{{ __('Checkout Page Breadcrumb Image') }}"
                    button_label="{{ __('Update Image') }}"  required="0"/>
            </div> --}}
            {{-- <div class="form-group col-md-4">
                <x-admin.form-image-preview div_id="payment_page_breadcrumb_image_preview"
                    label_id="payment_page_breadcrumb_image_label" input_id="payment_page_breadcrumb_image_upload"
                    :image="$setting?->payment_page_breadcrumb_image" name="payment_page_breadcrumb_image" label="{{ __('Checkout Page Breadcrumb Image') }}"
                    button_label="{{ __('Update Image') }}"  required="0"/>
            </div> --}}
            <div class="form-group col-12">
                <x-admin.update-button :text="__('Update')" />
            </div>
        </div>
    </form>
</div>
