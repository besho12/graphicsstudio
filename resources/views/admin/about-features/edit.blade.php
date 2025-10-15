@extends('admin.master_layout')
@section('title')
    <title>{{ __('Edit About Feature') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <x-admin.breadcrumb title="{{ __('Edit About Feature') }}" :list="[
                __('Dashboard') => route('admin.dashboard'),
                __('About Features') => route('admin.about-features.index'),
                __('Edit About Feature') => '#',
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
                                                href="{{ route('admin.about-features.edit', ['about_feature' => $aboutFeature->id, 'code' => $language->code]) }}"><i
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
                                <h4>{{ __('Edit About Feature') }}</h4>
                                <div>
                                    <a href="{{ route('admin.about-features.index') }}" class="btn btn-primary"><i
                                            class="fa fa-arrow-left"></i>{{ __('Back') }}</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.about-features.update', [
                                    'about_feature' => $aboutFeature->id,
                                    'code' => $code,
                                ]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label>{{ __('Title') }} <span class="text-danger">*</span></label>
                                            <input data-translate="true" type="text" id="title" class="form-control"
                                                name="title" value="{{ $aboutFeature?->getTranslation($code)?->title }}">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="description">{{ __('Description') }} <span class="text-danger">*</span></label>
                                            <textarea name="description" id="description" cols="30" rows="10" 
                                                class="form-control text-area-5" data-translate="true">{{ $aboutFeature?->getTranslation($code)?->description }}</textarea>
                                        </div>
                                        <div class="form-group col-md-12 {{ $code == $languages->first()->code ? '' : 'd-none' }}">
                            <label>{{ __('Order') }} <span class="text-danger">*</span></label>
                            <input type="number" id="order" class="form-control" name="order"
                                value="{{ $aboutFeature->order }}" min="0" readonly>
                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <button class="btn btn-primary">{{ __('Update') }}</button>
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