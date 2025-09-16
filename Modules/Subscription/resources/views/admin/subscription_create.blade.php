@extends('admin.master_layout')
@section('title')
    <title>{{ __('Create Plan') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <x-admin.breadcrumb title="{{ __('Create Plan') }}" :list="[
                __('Dashboard') => route('admin.dashboard'),
                __('Pricing Plan') => route('admin.pricing-plan.index'),
                __('Create Plan') => '#',
            ]" />

            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <x-admin.form-title :text="__('Create Plan')" />
                                <div>
                                    <x-admin.back-button :href="route('admin.pricing-plan.index')" />
                                </div>
                            </div>

                            <div class="card-body">

                                <form action="{{ route('admin.pricing-plan.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <x-admin.form-input id="plan_name" name="plan_name"
                                                label="{{ __('Plan Name') }}" placeholder="{{ __('Enter Plan Name') }}"
                                                value="{{ old('plan_name') }}" required="true" />
                                        </div>

                                        <div class="form-group col-md-6">
                                            <x-admin.form-input id="plan_price" name="plan_price"
                                                label="{{ __('Plan Price') }}" placeholder="{{ __('Enter Plan Price') }}"
                                                value="{{ old('plan_price') }}" type="number" required="true" />
                                        </div>

                                        <div class="form-group col-md-6">
                                            <x-admin.form-select id="expiration_date" name="expiration_date"
                                                label="{{ __('Expiration Date') }}" class="form-select" required="true">
                                                <x-admin.select-option :selected="old('expiration_date') == 'monthly'" value="monthly"
                                                    text="{{ __('Monthly') }}" />
                                                <x-admin.select-option :selected="old('expiration_date') == 'yearly'" value="yearly"
                                                    text="{{ __('Yearly') }}" />
                                                <x-admin.select-option :selected="old('expiration_date') == 'lifetime'" value="lifetime"
                                                    text="{{ __('Lifetime') }}" />
                                            </x-admin.form-select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <x-admin.form-input id="serial" name="serial" label="{{ __('Serial') }}"
                                                placeholder="{{ __('Enter Serial') }}" value="{{ old('serial') }}"
                                                type="number" required="true" />
                                        </div>

                                        <div class="form-group col-md-12">
                                            <div class="form-group">
                                                <x-admin.form-textarea id="short_description" name="short_description"
                                                    label="{{ __('Sort Description') }}"
                                                    placeholder="{{ __('Enter Sort Description') }}"
                                                    value="{{ old('short_description') }}" maxlength="255" />
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <x-admin.form-editor id="description" name="description" label="{{ __('Description') }}" value="{!! old('description') !!}" required="true"/>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <div class="form-group">
                                                <x-admin.form-input id="button_text" data-translate="true"
                                                    name="button_text" label="{{ __('Button Text') }}"
                                                    placeholder="{{ __('Enter Button Text') }}"
                                                    value="{{ old('button_text')}}"/>
                                                    <small class="text-danger">{{ __('leave blank for hide') }}</small>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <div class="form-group">
                                                <x-admin.form-input id="button_url" data-translate="true"
                                                    name="button_url" label="{{ __('Button url') }}"
                                                    placeholder="{{ __('Enter Button url') }}"
                                                    value="{{ old('button_url')}}" />
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <x-admin.form-switch name="status" label="{{ __('Status') }}" :checked="old('status') == Modules\Subscription\app\Enums\SubscriptionStatusType::ACTIVE->value" />
                                        </div>

                                        <div class="form-group col-md-12">
                                            <x-admin.save-button :text="__('Save')" />
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
