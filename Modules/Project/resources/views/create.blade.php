@extends('admin.master_layout')
@section('title')
    <title>{{ __('Create Project') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <x-admin.breadcrumb title="{{ __('Create Service') }}" :list="[
                __('Dashboard') => route('admin.dashboard'),
                __('Project List') => route('admin.project.index'),
                __('Create Project') => '#',
            ]" />
            <div class="section-body">
                <div class="mt-4 row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <x-admin.form-title :text="__('Create Project')" />
                                <div>
                                    <x-admin.back-button :href="route('admin.project.index')" />
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.project.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <!-- Project Thumbnail Image Section -->
                                        <div class="col-md-4">
                                            <div class="card border-info">
                                                <div class="card-header bg-info text-white">
                                                    <h6 class="mb-0"><i class="fas fa-th-large"></i> {{ __('Thumbnail Image') }}</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <x-admin.form-image-preview 
                                                            name="thumbnail"
                                                            :label="__('Thumbnail Image')" 
                                                            :button_label="__('Choose Thumbnail')"
                                                            required="true" />
                                                        <small class="form-text text-info mt-2">
                                                            <i class="fas fa-info-circle"></i> 
                                                            <strong>{{ __('Recommended Size') }}:</strong> 600×400px (3:2 ratio)<br>
                                                            <strong>{{ __('Usage') }}:</strong> Small image for portfolio listing page
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Project Main Image Section -->
                                        <div class="col-md-4">
                                            <div class="card border-primary">
                                                <div class="card-header bg-primary text-white">
                                                    <h6 class="mb-0"><i class="fas fa-image"></i> {{ __('Project Image') }}</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <x-admin.form-image-preview 
                                                            name="image"
                                                            :label="__('Main Project Image')" 
                                                            :button_label="__('Choose Project Image')"
                                                            required="true" />
                                                        <small class="form-text text-primary mt-2">
                                                            <i class="fas fa-info-circle"></i> 
                                                            <strong>{{ __('Recommended Size') }}:</strong> 1200×800px (3:2 ratio)<br>
                                                            <strong>{{ __('Usage') }}:</strong> Main hero image for project details page
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Project Gallery Images Section -->
                                        <div class="col-md-4">
                                            <div class="card border-success">
                                                <div class="card-header bg-success text-white">
                                                    <h6 class="mb-0"><i class="fas fa-images"></i> {{ __('Gallery Images') }} <span class="badge badge-light text-dark">{{ __('Optional') }}</span></h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label>{{ __('Gallery Images') }}</label>
                                                        <input type="file" name="gallery_images[]" id="gallery-images-upload" class="form-control" multiple accept="image/*">
                                                        <small class="form-text text-success mt-2">
                                                            <i class="fas fa-info-circle"></i> 
                                                            <strong>{{ __('Recommended Size') }}:</strong> 1200×800px (3:2 ratio)<br>
                                                            <strong>{{ __('Usage') }}:</strong> Additional images for project showcase and gallery
                                                        </small>
                                                        
                                                        <!-- Gallery Preview Container -->
                                                        <div id="gallery-preview" class="mt-3" style="display: none;">
                                                            <label class="form-label">{{ __('Gallery Preview') }}:</label>
                                                            <div id="gallery-images-container" class="d-flex flex-wrap gap-2"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">

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
                                            <x-admin.form-editor-with-image id="description" name="description" label="{{ __('Description') }}" value="{!! old('description') !!}" required="true"/>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>{{ __('Project Category') }} <span class="text-danger">*</span></label>
                                            <input type="text" id="project_category" class="form-control"
                                                name="project_category" value="{{ old('project_category') }}">
                                            @error('project_category')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <x-admin.form-select name="service_id" id="service_id" class="select2" label="{{ __('Service') }}" required="true">
                                                <x-admin.select-option value="" text="{{ __('Select Service') }}" />
                                                @foreach ($services as $service)
                                                    <x-admin.select-option :selected="$service?->id == old('service_id')" value="{{ $service?->id }}" text="{{ $service?->title }}" />
                                                @endforeach
                                            </x-admin.form-select>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>{{ __('Project Author') }} <span class="text-danger">*</span></label>
                                            <input type="text" id="project_author" class="form-control"
                                                name="project_author" value="{{ old('project_author') }}">
                                            @error('project_author')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>{{ __('Project Publish Date') }} <span class="text-danger">*</span></label>
                                            <input type="date" id="project_date" class="form-control" name="project_date"
                                                value="{{ old('project_date') }}">
                                            @error('project_date')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>{{ __('Tags') }}</label>
                                            <input type="text" class="form-control tags" name="tags"
                                                value="{{ old('tags') }}">
                                            @error('tags')
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
    <script src="{{ asset('backend/js/jquery.uploadPreview.min.js') }}"></script>
    <script>
        // Initialize thumbnail image preview
        $.uploadPreview({
            input_field: "#image-upload",
            preview_box: "#image-preview",
            label_field: "#image-label",
            label_default: "{{ __('Choose Thumbnail') }}",
            label_selected: "{{ __('Change Thumbnail') }}",
            no_label: false,
            success_callback: null
        });

        // Gallery images preview functionality
        $(document).ready(function() {
            // Handle gallery images selection
            $('#gallery-images-upload').on('change', function(e) {
                const files = e.target.files;
                const container = $('#gallery-images-container');
                const preview = $('#gallery-preview');
                
                // Clear previous previews
                container.empty();
                
                if (files.length > 0) {
                    preview.show();
                    
                    Array.from(files).forEach((file, index) => {
                        if (file.type.startsWith('image/')) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const imagePreview = `
                                    <div class="position-relative" style="width: 80px; height: 80px;">
                                        <img src="${e.target.result}" 
                                             class="img-thumbnail" 
                                             style="width: 80px; height: 80px; object-fit: cover;"
                                             title="${file.name}">
                                        <small class="d-block text-center text-truncate" style="width: 80px; font-size: 10px;">
                                            ${file.name.length > 12 ? file.name.substring(0, 12) + '...' : file.name}
                                        </small>
                                    </div>
                                `;
                                container.append(imagePreview);
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                } else {
                    preview.hide();
                }
            });

            // Auto-generate slug from title
            $("#title").on("keyup", function(e) {
                $("#slug").val(convertToSlug($(this).val()));
            });
        });

        function convertToSlug(Text) {
            return Text
                .toLowerCase()
                .replace(/[^\w ]+/g, '')
                .replace(/ +/g, '-');
        }
    </script>

    <style>
        /* Custom styles for image upload cards */
        .card.border-primary {
            border-width: 2px !important;
        }
        .card.border-success {
            border-width: 2px !important;
        }
        
        /* Gallery preview styles */
        #gallery-images-container {
            max-height: 200px;
            overflow-y: auto;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .col-md-6 {
                margin-bottom: 1rem;
            }
        }
    </style>
@endpush
