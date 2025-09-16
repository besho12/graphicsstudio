@extends('admin.master_layout')
@section('title')
    <title>{{ __('Create Product') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <x-admin.breadcrumb title="{{ __('Create Product') }}" :list="[
                __('Dashboard') => route('admin.dashboard'),
                __('Product List') => route('admin.product.index'),
                __('Create Product') => '#',
            ]" />
            <div class="section-body">
                <div class="row">
                    <form class="col-12" action="{{ route('admin.product.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between">
                                        <x-admin.form-title :text="__('Create Product')" />
                                        <div>
                                            <x-admin.back-button :href="route('admin.product.index')" />
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>{{ __('Title') }} <span class="text-danger">*</span></label>
                                            <input type="text" id="title" class="form-control" name="title"
                                                value="{{ old('title') }}">
                                            @error('title')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>{{ __('Slug') }} <span class="text-danger">*</span></label>
                                            <input type="text" id="slug" class="form-control" name="slug"
                                                value="{{ old('slug') }}">
                                            @error('slug')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>{{ __('Short Description') }}</label>
                                            <textarea maxlength="500" name="short_description" id="" cols="30" rows="10"
                                                class="form-control text-area-5">{{ old('short_description') }}</textarea>
                                            @error('short_description')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>{{ __('Description') }} <span class="text-danger">*</span></label>
                                            <textarea name="description" id="" cols="30" rows="8" class="summernote">{{ old('description') }}</textarea>
                                            @error('description')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>{{ __('SEO Title') }}</label>
                                            <input type="text" class="form-control" name="seo_title"
                                                value="{{ old('seo_title') }}">
                                            @error('seo_title')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>{{ __('SEO Description') }}</label>
                                            <textarea maxlength="1000" name="seo_description" id="" cols="30" rows="10"
                                                class="form-control text-area-5">{{ old('seo_description') }}</textarea>
                                            @error('seo_description')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <a class="btn btn-primary collapsed" data-bs-toggle="collapse"
                                                href="#collapseExample" role="button" aria-expanded="false"
                                                aria-controls="collapseExample">
                                                {{ __('Additional Information') }} <i class="fa fa-plus"></i>
                                            </a>
                                            <div class="collapse mt-3" id="collapseExample">
                                                <div class="form-group">
                                                    <label>{{ __('Information Description') }} <span
                                                            class="text-danger">*</span></label>
                                                    <textarea name="additional_description" id="" cols="20" rows="8" class="summernote">{{ old('additional_description') }}</textarea>
                                                    @error('additional_description')
                                                        <span class="text-danger error-message">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <input type="hidden" name="type" value="{{ $type }}">
                                        <div class="form-group {{ $is_digital ? '' : 'd-none' }}">
                                            <label for="myDropzone">{{ __('File') }} <span
                                                    class="text-danger">*</span></label>
                                            <div class="dropzone mb-2" id="myDropzone">
                                                <div class="dz-message d-flex flex-column">
                                                    <div class="img">
                                                        <img src="{{ asset('frontend/images/upload_2.png') }}"
                                                            alt="{{ __('Upload') }}" width="60px"
                                                            class="img-fluid h-auto">
                                                    </div>
                                                    <label>{{ __('Only .zip file is allowed. Drag & drop to upload.') }}
                                                    </label>
                                                </div>
                                            </div>
                                            <input type="text" id="file_path" class="form-control" name="file_path"
                                                value="{{ old('file_path') }}" readonly>
                                            @error('file_path')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <x-admin.form-image-preview />
                                        </div>
                                        <div class="form-group">
                                            <label>{{ __('SKU') }} <span class="text-danger">*</span></label>
                                            <input type="text" id="sku" class="form-control" name="sku"
                                                value="{{ old('sku') }}">
                                            @error('sku')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        @if (!$is_digital)
                                            <div class="form-group">
                                                <label>{{ __('Quantity') }} <span class="text-danger">*</span></label>
                                                <input type="number" id="qty" class="form-control" name="qty"
                                                    value="{{ old('qty') }}">
                                            </div>
                                        @endif
                                        <div class="form-group">
                                            <label>{{ __('Regular Price') }} <span class="text-danger">*</span></label>
                                            <input type="number" step="0.1" id="price" class="form-control"
                                                name="price" value="{{ old('price') }}">
                                            @error('price')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>{{ __('Sale Price') }}</label>
                                            <input type="number" step="0.1" id="sale_price" class="form-control"
                                                name="sale_price" value="{{ old('sale_price') }}">
                                            @error('sale_price')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>{{ __('Category') }} <span class="text-danger">*</span></label>
                                            <select name="product_category_id" class="form-control select2"
                                                id="category">
                                                <option value="">{{ __('Select Category') }}</option>
                                                @foreach ($categories as $category)
                                                    <option
                                                        {{ $category->id == old('product_category_id') ? 'selected' : '' }}
                                                        value="{{ $category->id }}">{{ $category->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('product_category_id')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                <input type="hidden" value="0" name="is_popular"
                                                    class="custom-switch-input">
                                                <input type="checkbox" value="1" name="is_popular"
                                                    class="custom-switch-input"
                                                    {{ old('is_popular') == 1 ? 'checked' : '' }}>
                                                <span class="custom-switch-indicator"></span>
                                                <span
                                                    class="custom-switch-description">{{ __('Mark as a Popular') }}</span>
                                            </label>
                                        </div>

                                        <div class="form-group">
                                            <label>
                                                <input type="hidden" value="0" name="is_new"
                                                    class="custom-switch-input">
                                                <input type="checkbox" value="1" name="is_new"
                                                    class="custom-switch-input" {{ old('is_new') == 1 ? 'checked' : '' }}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">{{ __('Mark as a New') }}</span>
                                            </label>
                                        </div>

                                        <div class="form-group">
                                            <label>
                                                <input type="hidden" value="0" name="status"
                                                    class="custom-switch-input">
                                                <input type="checkbox" value="1" name="status"
                                                    class="custom-switch-input" {{ old('status') == 1 ? 'checked' : '' }}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">{{ __('Status') }}</span>
                                            </label>
                                        </div>

                                        <div class="form-group">
                                            <label>{{ __('Tags') }}</label>
                                            <input type="text" class="form-control tags" name="tags"
                                                value="{{ old('tags') }}">
                                            @error('tags')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="text-center col-md-12">
                                <x-admin.save-button :text="__('Save')" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('js')
    <script src="{{ asset('backend/js/jquery.uploadPreview.min.js') }}"></script>
    <script>
        "use strict";
        $.uploadPreview({
            input_field: "#image-upload",
            preview_box: "#image-preview",
            label_field: "#image-label",
            label_default: "{{ __('Choose Image') }}",
            label_selected: "{{ __('Change Image') }}",
            no_label: false,
            success_callback: null
        });

        function convertToSlug(Text) {
            return Text
                .toLowerCase()
                .replace(/[^\w ]+/g, '')
                .replace(/ +/g, '-');
        }
        (function($) {
            "use strict";
            $(document).ready(function() {
                $("#title").on("keyup", function(e) {
                    $("#slug").val(convertToSlug($(this).val()));
                });
            });
        })(jQuery);
    </script>
    @if ($is_digital)
        <script src="{{ asset('backend/dropzone/dropzone.min.js') }}"></script>
        <script>
            const csrfToken = $('meta[name="csrf-token"]').attr("content");
            Dropzone.autoDiscover = false;

            const dz = new Dropzone("#myDropzone", {
                url: "{{ route('admin.product.file-store') }}",
                method: "post",
                chunking: true,
                forceChunking: true,
                parallelUploads: 1,
                maxFiles: 1,
                acceptedFiles: ".zip",
                chunkSize: Math.min("{{ server_max_upload_size() }}", 2 * 1024 * 1024),
                retryChunks: true,
                retryChunksLimit: 3,
                addRemoveLinks: true,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                init() {
                    this.on("success", (file, response) => handleUploadSuccess(file, response));
                    this.on("error", (file, errorMessage, xhr) => handleUploadError(file, errorMessage, xhr));
                    this.on("removedfile", () => deleteFile());
                },
                params(files, xhr, chunk) {
                    return {
                        dzuuid: chunk.file.upload.uuid,
                        dzchunkindex: chunk.index,
                        dztotalfilesize: chunk.file.size,
                        dzchunksize: this.options.chunkSize,
                        dztotalchunkcount: chunk.file.upload.totalChunkCount,
                        dzchunkbyteoffset: chunk.index * this.options.chunkSize,
                    };
                },
            });

            function handleUploadSuccess(file, response) {
                toastr[response.success ? "success" : "warning"](response.message);
                $('#file_path').val(response.filename);
            }

            function handleUploadError(file, errorMessage, xhr) {
                let message = "{{ __('Upload failed') }}";
                if (xhr?.response) {
                    try {
                        const response = JSON.parse(xhr.response);
                        message = response.message || "{{ __('Upload failed due to a server error.') }}";
                    } catch (e) {
                        message = errorMessage;
                    }
                }
                toastr.error(message);
                updateProgressBar(file.upload.uuid, false);
            }


            function deleteFile() {
                let filename = $('#file_path').val();
                filename = filename.split('/').pop();
                if (filename) {
                    $.ajax({
                        type: "delete",
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        url: "{{ route('admin.product.file-remove', 'file_name') }}".replace('file_name',
                            encodeURIComponent(filename)),
                        success: function(response) {
                            $('#file_path').val('');
                        },
                    });
                }
            }
        </script>
    @endif
@endpush
@if ($is_digital)
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/dropzone/dropzone.min.css') }}">
        <style>
            .dropzone {
                min-height: auto;
                padding: 0;
            }

            .dropzone label {
                font-size: 16px
            }

            .dropzone .dz-message {
                margin: .5rem 0;
            }
        </style>
    @endpush
@endif
