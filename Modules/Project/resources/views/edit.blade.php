@extends('admin.master_layout')
@section('title')
    <title>{{ __('Edit Project') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <x-admin.breadcrumb title="{{ __('Edit Project') }}" :list="[
                __('Dashboard') => route('admin.dashboard'),
                __('Project List') => route('admin.project.index'),
                __('Edit Project') => '#',
            ]" />
            <div class="section-body row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header gap-3 justify-content-between align-items-center">
                            <h5 class="m-0 service_card">{{ __('Available Translations') }}</h5>
                            @if ($code !== $languages->first()->code)
                                <x-admin.button id="translate-btn" :text="__('Translate')" />
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="lang_list_top">
                                <ul class="lang_list">
                                    @foreach ($languages = allLanguages() as $language)
                                        <li><a id="{{ request('code') == $language->code ? 'selected-language' : '' }}"
                                                href="{{ route('admin.project.edit', ['project' => $project->id, 'code' => $language->code]) }}"><i
                                                    class="fas {{ request('code') == $language->code ? 'fa-eye' : 'fa-edit' }}"></i>
                                                {{ $language->name }}</a></li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="mt-2 alert alert-danger" role="alert">
                                @php
                                    $current_language = $languages->where('code', request()->get('code'))->first();
                                @endphp
                                <p>{{ __('Your editing mode') }}:<b> {{ $current_language?->name }}</b></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($code == $languages->first()->code)
                @include('project::utilities.navbar')
            @endif
            
            <!-- Project Gallery Section -->
            @if ($code == $languages->first()->code && $project->images && $project->images->count() > 0)
                <div class="section-body">
                    <div class="mt-4 row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="mb-0">
                                        <i class="fas fa-images me-2 text-primary"></i>{{ __('Project Gallery') }}
                                        <span class="badge badge-info ms-2">{{ $project->images->count() }} {{ __('Images') }}</span>
                                    </h4>
                                    <div>
                                        <a href="{{ route('admin.project.gallery', $project->id) }}" class="btn btn-success btn-sm">
                                            <i class="fas fa-cog"></i> {{ __('Manage Gallery') }}
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @foreach($project->images as $image)
                                            <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-3">
                                                <div class="gallery-image-item">
                                                    <div class="image-wrapper">
                                                        <img src="{{ asset($image->large_image) }}" 
                                                             alt="Gallery Image {{ $loop->iteration }}" 
                                                             class="img-fluid rounded shadow-sm gallery-preview-image"
                                                             data-bs-toggle="modal" 
                                                             data-bs-target="#imageModal{{ $image->id }}">
                                                        <div class="image-overlay">
                                                            <i class="fas fa-search-plus text-white"></i>
                                                        </div>
                                                    </div>
                                                    <small class="text-muted d-block text-center mt-1">
                                                        {{ __('Image') }} {{ $loop->iteration }}
                                                    </small>
                                                </div>
                                                
                                                <!-- Image Modal -->
                                                <div class="modal fade" id="imageModal{{ $image->id }}" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">{{ __('Gallery Image') }} {{ $loop->iteration }}</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body text-center">
                                                                <img src="{{ asset($image->large_image) }}" 
                                                                     alt="Gallery Image {{ $loop->iteration }}" 
                                                                     class="img-fluid rounded">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    @if($project->images->count() == 0)
                                        <div class="text-center py-4">
                                            <i class="fas fa-images fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">{{ __('No gallery images uploaded yet.') }}</p>
                                            <a href="{{ route('admin.project.gallery', $project->id) }}" class="btn btn-primary">
                                                <i class="fas fa-plus"></i> {{ __('Add Gallery Images') }}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            
            <div class="section-body">
                <div class="mt-4 row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4>{{ __('Edit Project') }}</h4>
                                <div>
                                    <a href="{{ route('admin.project.index') }}" class="btn btn-primary"><i
                                            class="fa fa-arrow-left"></i>{{ __('Back') }}</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <form
                                    action="{{ route('admin.project.update', [
                                        'project' => $project->id,
                                        'code' => $code,
                                    ]) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">
                                        <!-- Image Upload Section -->
                                        <div class="col-12 {{ $code == $languages->first()->code ? '' : 'd-none' }}">
                                            <div class="row">
                                                <!-- Project Thumbnail -->
                                                <div class="col-md-4 mb-4">
                                                    <div class="card border-info">
                                                        <div class="card-header bg-info text-white">
                                                            <h6 class="mb-0">
                                                                <i class="fas fa-th-large me-2"></i>{{ __('Thumbnail Image') }}
                                                                <span class="text-warning">*</span>
                                                            </h6>
                                                        </div>
                                                        <div class="card-body">
                                                            <x-admin.form-image-preview 
                                                                name="thumbnail" 
                                                                :image="$project->thumbnail" 
                                                                div_id="thumbnail-image-preview"
                                                                label_id="thumbnail-image-label"
                                                                input_id="thumbnail-image-upload"
                                                                required="0"/>
                                                            <div class="mt-2">
                                                                <div class="alert alert-info py-2 px-3 mb-2">
                                                                    <i class="fas fa-star text-warning"></i> 
                                                                    <strong>{{ __('Perfect Universal Size') }}:</strong> 700×560px (5:4 ratio)
                                                                </div>
                                                                <small class="form-text text-success d-block">
                                                                    <i class="fas fa-check-circle"></i> 
                                                                    <strong>{{ __('Works perfectly on') }}:</strong> Desktop & Mobile devices
                                                                </small>
                                                                <small class="form-text text-primary d-block">
                                                                    <i class="fas fa-file-image"></i> 
                                                                    <strong>{{ __('Format') }}:</strong> JPEG, 85% quality, ~100KB
                                                                </small>
                                                                <small class="form-text text-muted d-block mt-1">
                                                                    {{ __('This single format ensures optimal display across all devices with crisp retina quality.') }}
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Project Main Image -->
                                                <div class="col-md-4 mb-4">
                                                    <div class="card border-primary">
                                                        <div class="card-header bg-primary text-white">
                                                            <h6 class="mb-0">
                                                                <i class="fas fa-image me-2"></i>{{ __('Project Image') }}
                                                                <span class="text-warning">*</span>
                                                            </h6>
                                                        </div>
                                                        <div class="card-body">
                                            <x-admin.form-image-preview 
                                                name="image" 
                                                :image="$project->image" 
                                                div_id="project-image-preview"
                                                label_id="project-image-label"
                                                input_id="project-image-upload"
                                                required="0"/>
                                            <small class="form-text text-primary mt-2">
                                                                <i class="fas fa-info-circle"></i> 
                                                                <strong>{{ __('Recommended Size') }}:</strong> 1200×800px (3:2 ratio)
                                                            </small>
                                                            <small class="form-text text-muted d-block">
                                                                {{ __('Main hero image for project details page') }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Gallery Images -->
                                                <div class="col-md-4 mb-4">
                                                    <div class="card border-success">
                                                        <div class="card-header bg-success text-white">
                                                            <h6 class="mb-0">
                                                                <i class="fas fa-images me-2"></i>{{ __('Gallery Images') }}
                                                                <small class="text-light">({{ __('Optional') }})</small>
                                                            </h6>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <input type="file" 
                                                                       id="gallery-images-upload" 
                                                                       name="gallery_images[]" 
                                                                       class="form-control" 
                                                                       multiple 
                                                                       accept="image/*">
                                                            </div>
                                                            <small class="form-text text-success">
                                                                <i class="fas fa-info-circle"></i> 
                                                                <strong>{{ __('Recommended Size') }}:</strong> 1200×800px (3:2 ratio)
                                                            </small>
                                                            <small class="form-text text-muted d-block">
                                                                {{ __('Additional images for project showcase and gallery') }}
                                                            </small>
                                                            
                                                            <!-- Gallery Preview -->
                                                            <div id="gallery-preview" class="mt-3" style="display: none;">
                                                                <h6 class="text-muted">{{ __('Selected Images') }}:</h6>
                                                                <div id="gallery-images-container" class="d-flex flex-wrap gap-2"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>{{ __('Title') }} <span class="text-danger">*</span></label>
                                            <input data-translate="true" type="text" id="title" class="form-control"
                                                name="title" value="{{ $project?->getTranslation($code)?->title }}">
                                        </div>

                                        <div class="form-group col-md-12">
                                            <x-admin.form-editor-with-image id="description" name="description"
                                                label="{{ __('Description') }}" value="{!! replaceImageSources($project->getTranslation($code)->description) !!}"
                                                required="true" data-translate="true" />
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>{{ __('Project Category') }} <span class="text-danger">*</span></label>
                                            <input type="text" id="project_category" class="form-control"
                                                name="project_category"
                                                value="{{ $project?->getTranslation($code)?->project_category }}"
                                                data-translate="true">
                                            @error('project_category')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <x-admin.form-select name="service_id" id="service_id" class="select2"
                                                label="{{ __('Service') }}" required="true">
                                                <x-admin.select-option value="" text="{{ __('Select Service') }}" />
                                                @foreach ($services as $service)
                                                    <x-admin.select-option :selected="$service?->id ==
                                                        old('service_id', $project?->service_id)" value="{{ $service?->id }}"
                                                        text="{{ $service?->title }}" />
                                                @endforeach
                                            </x-admin.form-select>
                                        </div>

                                        <div class="form-group col-md-6 {{ $code == $languages->first()->code ? '' : 'd-none' }}">
                                            <label>{{ __('Project Author') }} <span class="text-danger">*</span></label>
                                            <input type="text" id="project_author" class="form-control"
                                                name="project_author" value="{{ $project?->project_author }}">
                                            @error('project_author')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6 {{ $code == $languages->first()->code ? '' : 'd-none' }}">
                                            <label>{{ __('Project Publish Date') }}  <span class="text-danger">*</span></label>
                                            <input type="date" id="project_date" class="form-control" name="project_date"
                                                value="{{ $project->project_date }}">
                                            @error('project_date')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div
                                            class="form-group col-md-12 {{ $code == $languages->first()->code ? '' : 'd-none' }}">
                                            <label>{{ __('Tags') }}</label>
                                            <input type="text" class="form-control tags" name="tags"
                                                value="{{ $project->tags }}">
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>{{ __('SEO Title') }}</label>
                                            <input data-translate="true" type="text" class="form-control"
                                                name="seo_title"
                                                value="{{ $project?->getTranslation($code)?->seo_title }}">
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>{{ __('SEO Description') }}</label>
                                            <textarea maxlength="1000" data-translate="true" name="seo_description" id="" cols="30"
                                                rows="10" class="form-control text-area-5">{{ $project?->getTranslation($code)?->seo_description }}</textarea>
                                        </div>

                                        <div
                                            class="form-group col-md-12 {{ $code == $languages->first()->code ? '' : 'd-none' }}">
                                            <label>
                                                <input {{ $project->status == 1 ? 'checked' : '' }} type="checkbox"
                                                    value="1" name="status" class="custom-switch-input">
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">{{ __('Status') }}</span>
                                            </label>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="text-center col-md-12">
                                            <x-admin.update-button :text="__('Update')"></x-admin.update-button>
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
    @if ($code == $languages->first()->code)
        <script src="{{ asset('backend/js/jquery.uploadPreview.min.js') }}"></script>
        <script>
            // Initialize thumbnail image preview
            $.uploadPreview({
                input_field: "#thumbnail-image-upload",
                preview_box: "#thumbnail-image-preview",
                label_field: "#thumbnail-image-label",
                label_default: "{{ __('Choose Thumbnail') }}",
                label_selected: "{{ __('Change Thumbnail') }}",
                no_label: false,
                success_callback: null
            });

            // Initialize project image preview
            $.uploadPreview({
                input_field: "#project-image-upload",
                preview_box: "#project-image-preview",
                label_field: "#project-image-label",
                label_default: "{{ __('Choose Project Image') }}",
                label_selected: "{{ __('Change Project Image') }}",
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
            });
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
            
            /* Project Gallery Styles */
            .gallery-image-item {
                position: relative;
                transition: transform 0.3s ease;
            }
            
            .gallery-image-item:hover {
                transform: translateY(-5px);
            }
            
            .image-wrapper {
                position: relative;
                overflow: hidden;
                border-radius: 8px;
                cursor: pointer;
                aspect-ratio: 1;
            }
            
            .gallery-preview-image {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.3s ease;
            }
            
            .image-overlay {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                transition: opacity 0.3s ease;
            }
            
            .image-wrapper:hover .image-overlay {
                opacity: 1;
            }
            
            .image-wrapper:hover .gallery-preview-image {
                transform: scale(1.05);
            }
            
            /* Badge styling */
            .badge.badge-info {
                background-color: #17a2b8;
                color: white;
            }
            
            /* Responsive adjustments */
            @media (max-width: 768px) {
                .col-md-6 {
                    margin-bottom: 1rem;
                }
                
                .gallery-image-item {
                    margin-bottom: 1rem;
                }
            }
        </style>
    @else
        <script>
            'use strict';
            $('#translate-btn').on('click', function() {
                translateAllTo("{{ $code }}");
            })
        </script>
    @endif
@endpush
