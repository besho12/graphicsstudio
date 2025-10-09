@extends('admin.master_layout')
@section('title')
    <title>{{ __('FAQS') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <x-admin.breadcrumb title="{{ __('Create FAQ') }}" :list="[
                __('Dashboard') => route('admin.dashboard'),
                __('FAQS') => route('admin.faq.index'),
                __('Create FAQ') => '#',
            ]" />
            <div class="section-body">
                <div class="mt-4 row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <x-admin.form-title :text="__('Create FAQ')" />
                                <div>
                                    <x-admin.back-button :href="route('admin.faq.index')" />
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.faq.store') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <x-admin.form-input id="question"  name="question" label="{{ __('Question') }}" placeholder="{{ __('Enter Question') }}" value="{{ old('question') }}" required="true"/>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <x-admin.form-textarea id="answer" name="answer" label="{{ __('Answer') }}" placeholder="{{ __('Enter Answer') }}" value="{{ old('answer') }}" maxlength="1000" required="true"/>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="is_service_faq">{{ __('Is this a Service FAQ?') }}</label>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="is_service_faq" name="is_service_faq" value="1" {{ old('is_service_faq') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="is_service_faq">
                                                        {{ __('Make this FAQ specific to a service') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12" id="service_selection" style="display: none;">
                                            <div class="form-group">
                                                <x-admin.form-select name="service_id" id="service_id" class="select2"
                                                    label="{{ __('Service') }}" required="false">
                                                    <x-admin.select-option value="" text="{{ __('Select Service') }}" />
                                                    @foreach ($services as $service)
                                                        <x-admin.select-option :selected="$service?->id == old('service_id')" 
                                                            value="{{ $service?->id }}" text="{{ $service?->title }}" />
                                                    @endforeach
                                                </x-admin.form-select>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
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

@push('js')
<script>
    $(document).ready(function() {
        // Toggle service selection visibility
        $('#is_service_faq').change(function() {
            if ($(this).is(':checked')) {
                $('#service_selection').show();
                $('#service_id').attr('required', true);
            } else {
                $('#service_selection').hide();
                $('#service_id').attr('required', false);
                $('#service_id').val('').trigger('change');
            }
        });

        // Check initial state
        if ($('#is_service_faq').is(':checked')) {
            $('#service_selection').show();
            $('#service_id').attr('required', true);
        }
    });
</script>
@endpush
