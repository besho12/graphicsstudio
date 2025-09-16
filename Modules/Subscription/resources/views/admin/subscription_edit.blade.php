@extends('admin.master_layout')
@section('title')
    <title>{{ __('Edit Plan') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <x-admin.breadcrumb title="{{ __('Edit Plan') }}" :list="[
                __('Dashboard') => route('admin.dashboard'),
                __('Pricing Plan') => route('admin.pricing-plan.index'),
                __('Edit Plan') => '#',
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
                                    @foreach ($languages as $language)
                                        <li><a id="{{ request('code') == $language->code ? 'selected-language' : '' }}"
                                                href="{{ route('admin.pricing-plan.edit', ['pricing_plan'=>$plan->id,'code' => $language->code]) }}"><i
                                                    class="fas {{ request('code') == $language->code ? 'fa-eye' : 'fa-edit' }}"></i>
                                                {{ $language->name }}</a></li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="mt-2 alert alert-danger" role="alert">
                                @php
                                    $current_language = $languages->where('code', request()->get('code'))->first();
                                @endphp
                                <p>{{ __('Your editing mode') }} :
                                    <b>{{ $current_language?->name }}</b>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <x-admin.form-title :text="__('Edit Plan')" />
                                <div>
                                    <x-admin.back-button :href="route('admin.pricing-plan.index')" />
                                </div>
                            </div>

                            <div class="card-body">
                                <form action="{{ route('admin.pricing-plan.update', ['pricing_plan'=>$plan->id, 'code' => $code]) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">

                                        <div class="form-group col-md-{{ $code == $languages->first()->code ? '6' : '12' }}">
                                            <x-admin.form-input data-translate="true" id="plan_name" name="plan_name"
                                                label="{{ __('Plan Name') }}" placeholder="{{ __('Enter Plan Name') }}"
                                                value="{{ $plan?->getTranslation($code)?->plan_name }}" required="true" />
                                        </div>

                                        <div class="form-group col-md-6 {{ $code == $languages->first()->code ? '' : 'd-none' }}">
                                            <x-admin.form-input id="plan_price" name="plan_price"
                                                label="{{ __('Plan Price') }}" placeholder="{{ __('Enter Plan Price') }}"
                                                value="{{ $plan?->plan_price }}" type="number" required="true" />
                                        </div>

                                        <div class="form-group col-md-6 {{ $code == $languages->first()->code ? '' : 'd-none' }}">
                                            <x-admin.form-select id="expiration_date" name="expiration_date"
                                                label="{{ __('Expiration Date') }}" class="form-select" required="true">
                                                <x-admin.select-option :selected="$plan?->expiration_date == 'monthly'" value="monthly"
                                                    text="{{ __('Monthly') }}" />
                                                <x-admin.select-option :selected="$plan?->expiration_date == 'yearly'" value="yearly"
                                                    text="{{ __('Yearly') }}" />
                                                <x-admin.select-option :selected="$plan?->expiration_date == 'lifetime'" value="lifetime"
                                                    text="{{ __('Lifetime') }}" />
                                            </x-admin.form-select>
                                        </div>

                                        <div class="form-group col-md-6 {{ $code == $languages->first()->code ? '' : 'd-none' }}">
                                            <x-admin.form-input id="serial" name="serial" label="{{ __('Serial') }}"
                                                placeholder="{{ __('Enter Serial') }}" value="{{ $plan?->serial }}"
                                                type="number" required="true" />
                                        </div>

                                        <div class="form-group col-md-12">
                                            <div class="form-group">
                                                <x-admin.form-textarea data-translate="true" id="short_description"
                                                    name="short_description" label="{{ __('Sort Description') }}"
                                                    placeholder="{{ __('Enter Sort Description') }}"
                                                    value="{{ old('short_description', $plan?->getTranslation($code)?->short_description) }}"
                                                    maxlength="255" />
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <x-admin.form-editor id="description" name="description"
                                                label="{{ __('Description') }}" value="{!! $plan?->getTranslation($code)?->description !!}"
                                                required="true" data-translate="true"/>
                                        </div>

                                        <div class="form-group col-md-{{ $code == $languages->first()->code ? '6' : '12' }}">
                                            <div class="form-group">
                                                <x-admin.form-input id="button_text" data-translate="true"
                                                    name="button_text" label="{{ __('Button Text') }}"
                                                    placeholder="{{ __('Enter Button Text') }}"
                                                    value="{{ $plan?->getTranslation($code)?->button_text }}" />
                                                <small class="text-danger">{{ __('leave blank for hide') }}</small>
                                            </div>
                                        </div>

                                        <div
                                            class="form-group col-md-6 {{ $code == $languages->first()->code ? '' : 'd-none' }}">
                                            <div class="form-group">
                                                <x-admin.form-input id="button_url" name="button_url"
                                                    label="{{ __('Button url') }}"
                                                    placeholder="{{ __('Enter Button url') }}"
                                                    value="{{ $plan?->button_url }}" />
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6 {{ $code == $languages->first()->code ? '' : 'd-none' }}">
                                            <x-admin.form-switch name="status" label="{{ __('Status') }}"
                                                :checked="$plan?->status == Modules\Subscription\app\Enums\SubscriptionStatusType::ACTIVE->value" />
                                        </div>

                                        <div class="form-group col-md-12">
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
    <script src="{{ asset('backend/js/jquery.uploadPreview.min.js') }}"></script>
    <script>
        'use strict';
        $('#translate-btn').on('click', function() {
            translateAllTo("{{ $code }}");
        })
    </script>
@endpush

