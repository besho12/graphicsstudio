@extends('admin.master_layout')
@section('title')
    <title>{{ __('Create Service') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <x-admin.breadcrumb title="{{ __('Create Service') }}" :list="[
                __('Dashboard') => route('admin.dashboard'),
                __('Service List') => route('admin.service.index'),
                __('Create Service') => '#',
            ]" />
            <div class="section-body">
                <div class="mt-4 row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <x-admin.form-title :text="__('Create Service')" />
                                <div>
                                    <x-admin.back-button :href="route('admin.service.index')" />
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.service.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <x-admin.form-image-preview />
                                                <small class="form-text text-muted">
                                                    <strong>{{ __('Recommended Size:') }}</strong> 1296 × 700<br>
                                                    <em>{{ __('This image appears as the main thumbnail in service details page') }}</em>
                                                </small>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>{{ __('Existing Icon') }}<span class="text-danger">*</span></label>
                                                <div id="icon-preview" class="image-preview icon-preview">
                                                    <label for="icon-upload" id="icon-label">{{ __('Icon') }}</label>
                                                    <input type="file" name="icon" id="icon-upload">
                                                </div>
                                                <small class="form-text text-muted">
                                                    <strong>{{ __('Recommended Size:') }}</strong> 100px × 100px (1:1 aspect ratio) or 40 x 40 SVG<br>
                                                    <em>{{ __('This icon appears in service cards and feature sections') }}</em>
                                                </small>
                                                @error('icon')
                                                    <span class="text-danger error-message">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>{{ __('Title') }} <span class="text-danger">*</span></label>
                                            <input type="text" id="title" class="form-control" name="title"
                                                value="{{ old('title') }}">
                                            @error('title')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>{{ __('Slug') }} <span class="text-danger">*</span></label>
                                            <input type="text" id="slug" class="form-control" name="slug"
                                                value="{{ old('slug') }}">
                                            @error('slug')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="short_description">{{ __('Short Description') }} <span class="text-danger">*</span></label>
                                            <textarea maxlength="500" name="short_description" id="short_description" cols="30" rows="10"
                                                class="form-control text-area-5">{{ old('short_description') }}</textarea>
                                            @error('short_description')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>


                                        <div class="form-group col-md-12">
                                            <x-admin.form-editor-with-image id="description" name="description" label="{{ __('Description') }}" value="{!! old('description') !!}" required="true"/>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>{{ __('Button Text') }} <span class="text-danger">*</span></label>
                                            <input type="text" id="btn_text" class="form-control" name="btn_text"
                                                value="{{ old('btn_text') }}">
                                            @error('btn_text')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>{{ __('SEO Title') }}</label>
                                            <input type="text" class="form-control" name="seo_title"
                                                value="{{ old('seo_title') }}">
                                            @error('seo_title')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>{{ __('SEO Description') }}</label>
                                            <textarea maxlength="1000" name="seo_description" id="" cols="30" rows="10"
                                                class="form-control text-area-5">{{ old('seo_description') }}</textarea>
                                            @error('seo_description')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Key Benefits Section -->
                                        <div class="col-md-12">
                                            <h5 class="mb-3 mt-4">{{ __('Key Benefits') }}</h5>
                                            <p class="text-muted mb-3">{{ __('Add up to 3 key benefits that will be displayed on the service details page') }}</p>
                                        </div>

                                        <!-- Benefit 1 -->
                                        <div class="form-group col-md-6">
                                            <label>{{ __('Benefit 1 Title') }}</label>
                                            <input type="text" class="form-control" name="benefit_1_title"
                                                value="{{ old('benefit_1_title') }}" placeholder="{{ __('e.g., Fast Delivery') }}">
                                            @error('benefit_1_title')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>{{ __('Benefit 1 Description') }}</label>
                                            <textarea name="benefit_1_description" cols="30" rows="3"
                                                class="form-control" placeholder="{{ __('Brief description of this benefit') }}">{{ old('benefit_1_description') }}</textarea>
                                            @error('benefit_1_description')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Benefit 2 -->
                                        <div class="form-group col-md-6">
                                            <label>{{ __('Benefit 2 Title') }}</label>
                                            <input type="text" class="form-control" name="benefit_2_title"
                                                value="{{ old('benefit_2_title') }}" placeholder="{{ __('e.g., Quality Assurance') }}">
                                            @error('benefit_2_title')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>{{ __('Benefit 2 Description') }}</label>
                                            <textarea name="benefit_2_description" cols="30" rows="3"
                                                class="form-control" placeholder="{{ __('Brief description of this benefit') }}">{{ old('benefit_2_description') }}</textarea>
                                            @error('benefit_2_description')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Benefit 3 -->
                                        <div class="form-group col-md-6">
                                            <label>{{ __('Benefit 3 Title') }}</label>
                                            <input type="text" class="form-control" name="benefit_3_title"
                                                value="{{ old('benefit_3_title') }}" placeholder="{{ __('e.g., 24/7 Support') }}">
                                            @error('benefit_3_title')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>{{ __('Benefit 3 Description') }}</label>
                                            <textarea name="benefit_3_description" cols="30" rows="3"
                                                class="form-control" placeholder="{{ __('Brief description of this benefit') }}">{{ old('benefit_3_description') }}</textarea>
                                            @error('benefit_3_description')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Service Features Section -->
                                        <div class="col-md-12">
                                            <h5 class="mb-3 mt-4">{{ __('Service Features') }}</h5>
                                            <p class="text-muted mb-3">{{ __('Add up to 3 key features that will be displayed on the service details page') }}</p>
                                        </div>

                                        <!-- Feature 1 -->
                                        <div class="form-group col-md-4">
                                            <label>{{ __('Feature 1 Title') }}</label>
                                            <input type="text" class="form-control" name="feature_1_title"
                                                value="{{ old('feature_1_title') }}" placeholder="{{ __('e.g., Custom Design') }}">
                                            @error('feature_1_title')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>{{ __('Feature 1 Description') }}</label>
                                            <textarea name="feature_1_description" cols="30" rows="3"
                                                class="form-control" placeholder="{{ __('Brief description of this feature') }}">{{ old('feature_1_description') }}</textarea>
                                            @error('feature_1_description')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>{{ __('Feature 1 Highlight') }}</label>
                                            <input type="text" class="form-control" name="feature_1_highlight"
                                                value="{{ old('feature_1_highlight') }}" placeholder="{{ __('e.g., 100% Custom') }}">
                                            @error('feature_1_highlight')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Feature 2 -->
                                        <div class="form-group col-md-4">
                                            <label>{{ __('Feature 2 Title') }}</label>
                                            <input type="text" class="form-control" name="feature_2_title"
                                                value="{{ old('feature_2_title') }}" placeholder="{{ __('e.g., Professional Quality') }}">
                                            @error('feature_2_title')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>{{ __('Feature 2 Description') }}</label>
                                            <textarea name="feature_2_description" cols="30" rows="3"
                                                class="form-control" placeholder="{{ __('Brief description of this feature') }}">{{ old('feature_2_description') }}</textarea>
                                            @error('feature_2_description')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>{{ __('Feature 2 Highlight') }}</label>
                                            <input type="text" class="form-control" name="feature_2_highlight"
                                                value="{{ old('feature_2_highlight') }}" placeholder="{{ __('e.g., HD Quality') }}">
                                            @error('feature_2_highlight')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Feature 3 -->
                                        <div class="form-group col-md-4">
                                            <label>{{ __('Feature 3 Title') }}</label>
                                            <input type="text" class="form-control" name="feature_3_title"
                                                value="{{ old('feature_3_title') }}" placeholder="{{ __('e.g., Fast Turnaround') }}">
                                            @error('feature_3_title')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>{{ __('Feature 3 Description') }}</label>
                                            <textarea name="feature_3_description" cols="30" rows="3"
                                                class="form-control" placeholder="{{ __('Brief description of this feature') }}">{{ old('feature_3_description') }}</textarea>
                                            @error('feature_3_description')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>{{ __('Feature 3 Highlight') }}</label>
                                            <input type="text" class="form-control" name="feature_3_highlight"
                                                value="{{ old('feature_3_highlight') }}" placeholder="{{ __('e.g., 24-48 Hours') }}">
                                            @error('feature_3_highlight')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Service Process Steps Section -->
                                        <div class="col-md-12">
                                            <h5 class="mb-3 mt-4">{{ __('Service Process Steps') }}</h5>
                                            <p class="text-muted mb-3">{{ __('Add up to 4 process steps that will be displayed on the service details page') }}</p>
                                        </div>

                                        <!-- Process Step 1 -->
                                        <div class="form-group col-md-6">
                                            <label>{{ __('Process Step 1 Title') }}</label>
                                            <input type="text" class="form-control" name="process_1_title"
                                                value="{{ old('process_1_title') }}" placeholder="{{ __('e.g., Discovery & Planning') }}">
                                            @error('process_1_title')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>{{ __('Process Step 1 Description') }}</label>
                                            <textarea name="process_1_description" cols="30" rows="3"
                                                class="form-control" placeholder="{{ __('Brief description of this process step') }}">{{ old('process_1_description') }}</textarea>
                                            @error('process_1_description')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Process Step 2 -->
                                        <div class="form-group col-md-6">
                                            <label>{{ __('Process Step 2 Title') }}</label>
                                            <input type="text" class="form-control" name="process_2_title"
                                                value="{{ old('process_2_title') }}" placeholder="{{ __('e.g., Design & Development') }}">
                                            @error('process_2_title')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>{{ __('Process Step 2 Description') }}</label>
                                            <textarea name="process_2_description" cols="30" rows="3"
                                                class="form-control" placeholder="{{ __('Brief description of this process step') }}">{{ old('process_2_description') }}</textarea>
                                            @error('process_2_description')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Process Step 3 -->
                                        <div class="form-group col-md-6">
                                            <label>{{ __('Process Step 3 Title') }}</label>
                                            <input type="text" class="form-control" name="process_3_title"
                                                value="{{ old('process_3_title') }}" placeholder="{{ __('e.g., Review & Refinement') }}">
                                            @error('process_3_title')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>{{ __('Process Step 3 Description') }}</label>
                                            <textarea name="process_3_description" cols="30" rows="3"
                                                class="form-control" placeholder="{{ __('Brief description of this process step') }}">{{ old('process_3_description') }}</textarea>
                                            @error('process_3_description')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Process Step 4 -->
                                        <div class="form-group col-md-6">
                                            <label>{{ __('Process Step 4 Title') }}</label>
                                            <input type="text" class="form-control" name="process_4_title"
                                                value="{{ old('process_4_title') }}" placeholder="{{ __('e.g., Delivery & Support') }}">
                                            @error('process_4_title')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>{{ __('Process Step 4 Description') }}</label>
                                            <textarea name="process_4_description" cols="30" rows="3"
                                                class="form-control" placeholder="{{ __('Brief description of this process step') }}">{{ old('process_4_description') }}</textarea>
                                            @error('process_4_description')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>
                                                <input type="hidden" value="0" name="status"
                                                    class="custom-switch-input">
                                                <input type="checkbox" value="1" name="status"
                                                    class="custom-switch-input" {{ old('status') == 1 ? 'checked' : '' }}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">{{ __('Status') }}</span>
                                            </label>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="text-center col-md-12">
                                            <x-admin.save-button :text="__('Save')"></x-admin.save-button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('js')
    {{-- Image preview --}}
    <script src="{{ asset('backend/js/jquery.uploadPreview.min.js') }}"></script>
    <script>
        $.uploadPreview({
            input_field: "#image-upload",
            preview_box: "#image-preview",
            label_field: "#image-label",
            label_default: "{{ __('Choose Image') }}",
            label_selected: "{{ __('Change Image') }}",
            no_label: false,
            success_callback: null
        });
        $.uploadPreview({
            input_field: "#icon-upload",
            preview_box: "#icon-preview",
            label_field: "#icon-label",
            label_default: "{{ __('Choose Icon') }}",
            label_selected: "{{ __('Change Icon') }}",
            no_label: false,
            success_callback: null
        });

        (function($) {
            "use strict";
            $(document).ready(function() {
                $("#title").on("keyup", function(e) {
                    $("#slug").val(convertToSlug($(this).val()));
                })
            });
        })(jQuery);

        function convertToSlug(Text) {
            return Text
                .toLowerCase()
                .replace(/[^\w ]+/g, '')
                .replace(/ +/g, '-');
        }
    </script>
@endpush
