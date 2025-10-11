@extends('admin.master_layout')
@section('title')
    <title>{{ __('Edit Service') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <x-admin.breadcrumb title="{{ __('Edit Service') }}" :list="[
                __('Dashboard') => route('admin.dashboard'),
                __('Service List') => route('admin.service.index'),
                __('Edit Service') => '#',
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
                                                href="{{ route('admin.service.edit', ['service' => $service->id, 'code' => $language->code]) }}"><i
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
            <div class="section-body">
                <div class="mt-4 row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4>{{ __('Edit Service') }}</h4>
                                <div>
                                    <a href="{{ route('admin.service.index') }}" class="btn btn-primary"><i
                                            class="fa fa-arrow-left"></i>{{ __('Back') }}</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <form
                                    action="{{ route('admin.service.update', [
                                        'service' => $service->id,
                                        'code' => $code,
                                    ]) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">
                                        <div
                                            class="form-group col-md-4 {{ $code == $languages->first()->code ? '' : 'd-none' }}">
                                            <x-admin.form-image-preview :image="$service->image" required="0" />
                                            <small class="form-text text-muted">
                                                <strong>{{ __('Recommended Size:') }}</strong> 1296 × 700<br>
                                                <em>{{ __('This image appears as the main thumbnail in service details page') }}</em>
                                            </small>
                                        </div>
                                        <div
                                            class="form-group col-md-4 {{ $code == $languages->first()->code ? '' : 'd-none' }}">
                                            <label>{{ __('Existing Icon') }}</label>
                                            <div id="icon-preview" class="image-preview icon-preview"
                                                @if ($service->icon ?? false) style="background-image: url({{ asset($service->icon) }});" @endif>
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
                                        <div class="form-group col-md-12">
                                            <label>{{ __('Title') }} <span class="text-danger">*</span></label>
                                            <input data-translate="true" type="text" id="title" class="form-control"
                                                name="title" value="{{ $service?->getTranslation($code)?->title }}">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="short_description">{{ __('Short Description') }} <span class="text-danger">*</span></label>
                                            <textarea maxlength="500" name="short_description" id="short_description" cols="30" rows="10"
                                                class="form-control text-area-5" data-translate="true">{{ $service?->getTranslation($code)?->short_description }}</textarea>
                                            @error('short_description')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-12">
                                            <x-admin.form-editor-with-image id="description" name="description"
                                                label="{{ __('Description') }}" value="{!! replaceImageSources($service->getTranslation($code)->description) !!}"
                                                required="true" data-translate="true" />
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>{{ __('Button Text') }} <span class="text-danger">*</span></label>
                                            <input type="text" id="btn_text" class="form-control" name="btn_text"
                                                value="{{ $service?->getTranslation($code)?->btn_text }}"
                                                data-translate="true">
                                            @error('btn_text')
                                                <span class="text-danger error-message">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>{{ __('SEO Title') }}</label>
                                            <input data-translate="true" type="text" class="form-control"
                                                name="seo_title"
                                                value="{{ $service?->getTranslation($code)?->seo_title }}">
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>{{ __('SEO Description') }}</label>
                                            <textarea maxlength="1000" data-translate="true" name="seo_description" id="" cols="30" rows="10"
                                                class="form-control text-area-5">{{ $service?->getTranslation($code)?->seo_description }}</textarea>
                                        </div>

                                        <!-- Key Benefits Section -->
                                        <div class="col-md-12">
                                            <h5 class="mb-3 mt-4">{{ __('Key Benefits') }}</h5>
                                            <p class="text-muted mb-3">{{ __('Add up to 3 key benefits that will be displayed on the service details page') }}</p>
                                        </div>

                                        <!-- Benefit 1 -->
                                        <div class="form-group col-md-6">
                                            <label>{{ __('Benefit 1 Title') }}</label>
                                            <input type="text" class="form-control" data-translate="true" name="benefit_1_title"
                                                value="{{ $service?->getTranslation($code)?->benefit_1_title }}" placeholder="{{ __('e.g., Fast Delivery') }}">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>{{ __('Benefit 1 Description') }}</label>
                                            <textarea name="benefit_1_description" data-translate="true" cols="30" rows="3"
                                                class="form-control" placeholder="{{ __('Brief description of this benefit') }}">{{ $service?->getTranslation($code)?->benefit_1_description }}</textarea>
                                        </div>

                                        <!-- Benefit 2 -->
                                        <div class="form-group col-md-6">
                                            <label>{{ __('Benefit 2 Title') }}</label>
                                            <input type="text" class="form-control" data-translate="true" name="benefit_2_title"
                                                value="{{ $service?->getTranslation($code)?->benefit_2_title }}" placeholder="{{ __('e.g., Quality Assurance') }}">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>{{ __('Benefit 2 Description') }}</label>
                                            <textarea name="benefit_2_description" data-translate="true" cols="30" rows="3"
                                                class="form-control" placeholder="{{ __('Brief description of this benefit') }}">{{ $service?->getTranslation($code)?->benefit_2_description }}</textarea>
                                        </div>

                                        <!-- Benefit 3 -->
                                        <div class="form-group col-md-6">
                                            <label>{{ __('Benefit 3 Title') }}</label>
                                            <input type="text" class="form-control" data-translate="true" name="benefit_3_title"
                                                value="{{ $service?->getTranslation($code)?->benefit_3_title }}" placeholder="{{ __('e.g., 24/7 Support') }}">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>{{ __('Benefit 3 Description') }}</label>
                                            <textarea name="benefit_3_description" data-translate="true" cols="30" rows="3"
                                                class="form-control" placeholder="{{ __('Brief description of this benefit') }}">{{ $service?->getTranslation($code)?->benefit_3_description }}</textarea>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>{{ __('Benefit 4 Title') }}</label>
                                            <input type="text" class="form-control" data-translate="true" name="benefit_4_title"
                                                value="{{ $service?->getTranslation($code)?->benefit_4_title }}" placeholder="{{ __('e.g., Guaranteed Results') }}">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>{{ __('Benefit 4 Description') }}</label>
                                            <textarea name="benefit_4_description" data-translate="true" cols="30" rows="3"
                                                class="form-control" placeholder="{{ __('Brief description of this benefit') }}">{{ $service?->getTranslation($code)?->benefit_4_description }}</textarea>
                                        </div>

                                        <!-- Service Features Section -->
                                        <div class="col-md-12">
                                            <h5 class="mb-3 mt-4">{{ __('Service Features') }}</h5>
                                            <p class="text-muted mb-3">{{ __('Add up to 3 key features that will be displayed on the service details page') }}</p>
                                        </div>

                                        <!-- Feature 1 -->
                                        <div class="form-group col-md-4">
                                            <label>{{ __('Feature 1 Title') }}</label>
                                            <input type="text" class="form-control" data-translate="true" name="feature_1_title"
                                                value="{{ $service?->getTranslation($code)?->feature_1_title }}" placeholder="{{ __('e.g., Custom Design') }}">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>{{ __('Feature 1 Description') }}</label>
                                            <textarea name="feature_1_description" data-translate="true" cols="30" rows="3"
                                                class="form-control" placeholder="{{ __('Brief description of this feature') }}">{{ $service?->getTranslation($code)?->feature_1_description }}</textarea>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>{{ __('Feature 1 Highlight') }}</label>
                                            <input type="text" class="form-control" data-translate="true" name="feature_1_highlight"
                                                value="{{ $service?->getTranslation($code)?->feature_1_highlight }}" placeholder="{{ __('e.g., 100% Custom') }}">
                                        </div>

                                        <!-- Feature 2 -->
                                        <div class="form-group col-md-4">
                                            <label>{{ __('Feature 2 Title') }}</label>
                                            <input type="text" class="form-control" data-translate="true" name="feature_2_title"
                                                value="{{ $service?->getTranslation($code)?->feature_2_title }}" placeholder="{{ __('e.g., Professional Quality') }}">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>{{ __('Feature 2 Description') }}</label>
                                            <textarea name="feature_2_description" data-translate="true" cols="30" rows="3"
                                                class="form-control" placeholder="{{ __('Brief description of this feature') }}">{{ $service?->getTranslation($code)?->feature_2_description }}</textarea>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>{{ __('Feature 2 Highlight') }}</label>
                                            <input type="text" class="form-control" data-translate="true" name="feature_2_highlight"
                                                value="{{ $service?->getTranslation($code)?->feature_2_highlight }}" placeholder="{{ __('e.g., HD Quality') }}">
                                        </div>

                                        <!-- Feature 3 -->
                                        <div class="form-group col-md-4">
                                            <label>{{ __('Feature 3 Title') }}</label>
                                            <input type="text" class="form-control" data-translate="true" name="feature_3_title"
                                                value="{{ $service?->getTranslation($code)?->feature_3_title }}" placeholder="{{ __('e.g., Fast Turnaround') }}">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>{{ __('Feature 3 Description') }}</label>
                                            <textarea name="feature_3_description" data-translate="true" cols="30" rows="3"
                                                class="form-control" placeholder="{{ __('Brief description of this feature') }}">{{ $service?->getTranslation($code)?->feature_3_description }}</textarea>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>{{ __('Feature 3 Highlight') }}</label>
                                            <input type="text" class="form-control" data-translate="true" name="feature_3_highlight"
                                                value="{{ $service?->getTranslation($code)?->feature_3_highlight }}" placeholder="{{ __('e.g., 24-48 Hours') }}">
                                        </div>

                                        <!-- Service Process Steps Section -->
                                        <div class="col-md-12">
                                            <h5 class="mb-3 mt-4">{{ __('Service Process Steps') }}</h5>
                                            <p class="text-muted mb-3">{{ __('Add up to 4 process steps that will be displayed on the service details page') }}</p>
                                        </div>

                                        <!-- Process Step 1 -->
                                        <div class="form-group col-md-6">
                                            <label>{{ __('Process Step 1 Title') }}</label>
                                            <input type="text" class="form-control" data-translate="true" name="process_1_title"
                                                value="{{ $service?->getTranslation($code)?->process_1_title }}" placeholder="{{ __('e.g., Discovery & Planning') }}">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>{{ __('Process Step 1 Description') }}</label>
                                            <textarea name="process_1_description" data-translate="true" cols="30" rows="3"
                                                class="form-control" placeholder="{{ __('Brief description of this process step') }}">{{ $service?->getTranslation($code)?->process_1_description }}</textarea>
                                        </div>

                                        <!-- Process Step 2 -->
                                        <div class="form-group col-md-6">
                                            <label>{{ __('Process Step 2 Title') }}</label>
                                            <input type="text" class="form-control" data-translate="true" name="process_2_title"
                                                value="{{ $service?->getTranslation($code)?->process_2_title }}" placeholder="{{ __('e.g., Design & Development') }}">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>{{ __('Process Step 2 Description') }}</label>
                                            <textarea name="process_2_description" data-translate="true" cols="30" rows="3"
                                                class="form-control" placeholder="{{ __('Brief description of this process step') }}">{{ $service?->getTranslation($code)?->process_2_description }}</textarea>
                                        </div>

                                        <!-- Process Step 3 -->
                                        <div class="form-group col-md-6">
                                            <label>{{ __('Process Step 3 Title') }}</label>
                                            <input type="text" class="form-control" data-translate="true" name="process_3_title"
                                                value="{{ $service?->getTranslation($code)?->process_3_title }}" placeholder="{{ __('e.g., Review & Refinement') }}">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>{{ __('Process Step 3 Description') }}</label>
                                            <textarea name="process_3_description" data-translate="true" cols="30" rows="3"
                                                class="form-control" placeholder="{{ __('Brief description of this process step') }}">{{ $service?->getTranslation($code)?->process_3_description }}</textarea>
                                        </div>

                                        <!-- Process Step 4 -->
                                        <div class="form-group col-md-6">
                                            <label>{{ __('Process Step 4 Title') }}</label>
                                            <input type="text" class="form-control" data-translate="true" name="process_4_title"
                                                value="{{ $service?->getTranslation($code)?->process_4_title }}" placeholder="{{ __('e.g., Delivery & Support') }}">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>{{ __('Process Step 4 Description') }}</label>
                                            <textarea name="process_4_description" data-translate="true" cols="30" rows="3"
                                                class="form-control" placeholder="{{ __('Brief description of this process step') }}">{{ $service?->getTranslation($code)?->process_4_description }}</textarea>
                                        </div>

                                        <div
                                            class="form-group col-md-12 {{ $code == $languages->first()->code ? '' : 'd-none' }}">
                                            <label>
                                                <input type="hidden" value="0" name="status"
                                                    class="custom-switch-input">
                                                <input type="checkbox" value="1" name="status"
                                                    class="custom-switch-input"
                                                    {{ $service->status == 1 ? 'checked' : '' }}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">{{ __('Status') }}</span>
                                            </label>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="text-center col-md-12">
                                            <x-admin.update-button :text="__('Update')" />
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
        </script>
    @else
        <script>
            'use strict';
            $('#translate-btn').on('click', function() {
                translateAllTo("{{ $code }}");
            })
        </script>
    @endif
@endpush
