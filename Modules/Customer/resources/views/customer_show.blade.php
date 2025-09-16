@extends('admin.master_layout')
@section('title')
    <title>{{ __('Customer Details') }}</title>
@endsection
@section('admin-content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <x-admin.breadcrumb title="{{ __('Customer Details') }}" :list="[
                __('Dashboard') => route('admin.dashboard'),
                __('Customer Details') => '#',
            ]" />

            <div class="section-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card shadow">
                            <img src="{{ !empty($user?->image) ? asset($user?->image) : asset($setting->default_avatar) }}"
                                class="profile_img w-100">

                            <div class="container my-3">
                                <h4>{{ html_decode($user->name) }}</h4>

                                @if ($user->phone)
                                    <p class="title mb-0">{{ html_decode($user->phone) }}</p>
                                @endif

                                <p class="title mb-0">{{ html_decode($user->email) }}</p>

                                <p class="title mb-0">{{ __('Joined') }} : {{ formattedDateTime($user->created_at) }}</p>

                                @if ($user->is_banned == 'yes')
                                    <p class="title mb-0">{{ __('Banned') }} : <b>{{ __('Yes') }}</b></p>
                                @else
                                    <p class="title mb-0">{{ __('Banned') }} : <b>{{ __('No') }}</b></p>
                                @endif

                                @if ($user->email_verified_at)
                                    <p class="title mb-2">{{ __('Email verified') }} : <b>{{ __('Yes') }}</b> </p>
                                @else
                                    <p class="title mb-2">{{ __('Email verified') }} : <b>{{ __('None') }}</b> </p>
                                    @adminCan('customer.update')
                                        <x-admin.button variant="success" class="mb-3" data-bs-toggle="modal"
                                            data-bs-target="#verifyModal" :text="__('Send Verify Link to Mail')" />
                                    @endadminCan
                                @endif

                                @adminCan('customer.update')
                                    <x-admin.button class="sendMail mb-3" data-bs-toggle="modal" data-bs-target="#sendMailModal"
                                        :text="__('Send Mail To Customer')" />

                                    @if ($user->is_banned == 'yes')
                                        <x-admin.button variant="warning" class="mb-3" data-bs-toggle="modal"
                                            data-bs-target="#bannedModal" :text="__('Remove From Banned')" />
                                    @else
                                        <x-admin.button variant="warning" class="mb-3" data-bs-toggle="modal"
                                            data-bs-target="#bannedModal" :text="__('Ban Customer')" />
                                    @endif
                                @endadminCan

                                @adminCan('customer.delete')
                                        <a href="{{ route('admin.customer-delete', $user->id) }}"
                                            data-modal="#deleteModal"
                                            class="delete-btn btn btn-danger btn-sm">{{__('Delete Account')}}</a>
                                @endadminCan
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9">
                        {{-- profile information card area --}}
                        <div class="card">
                            <div class="card-header">
                                <x-admin.form-title :text="__('Profile Information')" />
                            </div>
                            <div class="card-body">
                                <form
                                    action="{{ checkAdminHasPermission('customer.update') ? route('admin.customer-info-update', $user->id) : '' }}"
                                    method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <x-admin.form-input id="name" name="name" label="{{ __('Name') }}"
                                                placeholder="{{ __('Enter Name') }}"
                                                value="{{ html_decode($user->name) }}" required="true" />
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <x-admin.form-input type="email" id="email" name="email"
                                                label="{{ __('Email') }}" placeholder="{{ __('Enter Email') }}"
                                                value="{{ html_decode($user->email) }}" required="true"/>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <x-admin.form-input id="phone" name="phone" label="{{ __('Phone') }}"
                                                placeholder="{{ __('Enter Phone') }}"
                                                value="{{ html_decode($user->phone) }}" required="true" />
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <x-admin.form-input id="age" name="age" label="{{ __('Age') }}"
                                                placeholder="{{ __('Age') }}"
                                                value="{{ html_decode($user->age) }}" />
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <x-admin.form-select name="gender" id="gender" class="select2"
                                                label="{{ __('Select Gender') }}" required="true">
                                                <x-admin.select-option value="" text="{{ __('Select Gender') }}" />
                                                <x-admin.select-option :selected="old('gender') ?? strtolower($user->gender) == 'male'" value="male" text="{{ __('Male') }}" />
                                                    <x-admin.select-option :selected="old('gender') ?? strtolower($user->gender) == 'female'" value="female" text="{{ __('Female') }}" />
                                            </x-admin.form-select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <x-admin.form-select name="country_id" id="country_id" class="select2"
                                                label="{{ __('Select Country') }}" required="true">
                                                <x-admin.select-option value="" text="{{ __('Select Country') }}" />
                                                @foreach ($countries as $country)
                                                    <x-admin.select-option :selected="$country->id == old('country_id', $user->country_id)" value="{{ $country->id }}"
                                                        text="{{ $country->name }}" />
                                                @endforeach
                                            </x-admin.form-select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <x-admin.form-input id="province" name="province" label="{{ __('Province') }}"
                                                placeholder="{{ __('Province') }}"
                                                value="{{ html_decode($user->province) }}" />
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <x-admin.form-input id="city" name="city" label="{{ __('City') }}"
                                                placeholder="{{ __('City') }}"
                                                value="{{ html_decode($user->city) }}" />
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <x-admin.form-input id="zip_code" name="zip_code" label="{{ __('Zip code') }}"
                                                placeholder="{{ __('Zip code') }}"
                                                value="{{ html_decode($user->zip_code) }}" />
                                        </div>


                                        <div class="col-md-6 mb-3">
                                            <x-admin.form-input id="address" name="address"
                                                label="{{ __('Address') }}" placeholder="{{ __('Enter Address') }}"
                                                value="{{ html_decode($user->address) }}" />
                                        </div>
                                        @adminCan('customer.update')
                                            <div class="col-md-12 mt-4">
                                                <x-admin.update-button :text="__('Update Profile')" />
                                            </div>
                                        @endadminCan
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- change password card area --}}
                        <div class="card">
                            <div class="card-header">
                                <x-admin.form-title :text="__('Change Password')" />
                            </div>
                            <div class="card-body">
                                <form
                                    action="{{ checkAdminHasPermission('customer.update') ? route('admin.customer-password-change', $user->id) : '' }}"
                                    method="post">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <x-admin.form-input type="password" id="password" name="password"
                                                label="{{ __('Password') }}" placeholder="{{ __('Enter Password') }}"
                                                required="true" />
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <x-admin.form-input type="password" id="password_confirmation"
                                                name="password_confirmation" label="{{ __('Confirm Password') }}"
                                                placeholder="{{ __('Enter Confirm Password') }}" required="true" />
                                        </div>
                                        @adminCan('customer.update')
                                            <div class="col-md-12 mt-4">
                                                <x-admin.update-button :text="__('Change Password')" />
                                            </div>
                                        @endadminCan
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- banned history card area --}}
                        <div class="card">
                            <div class="card-header">
                                <x-admin.form-title :text="__('Banned History')" />
                            </div>
                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th width="30%">{{ __('Subject') }}</th>
                                            <th width="30%">{{ __('Description') }}</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($banned_histories as $banned_history)
                                            <tr>
                                                <td>{{ $banned_history->subject }}</td>
                                                <td>{!! nl2br($banned_history->description) !!}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>

    @adminCan('customer.update')
        <!-- Start Banned modal -->
        <div class="modal fade" id="bannedModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Send Mail') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form action="{{ route('admin.send-banned-request', $user->id) }}" method="POST">
                                @csrf

                                <div class="form-group">
                                    <x-admin.form-input id="banned_user_subject" name="subject" label="{{ __('Subject') }}"
                                        placeholder="{{ __('Enter Subject') }}" value="{{ old('subject') }}"
                                        required="true" />
                                </div>

                                <div class="form-group">
                                    <x-admin.form-textarea id="banned_user_description" name="description"
                                        label="{{ __('Description') }}" placeholder="{{ __('Enter Description') }}"
                                        value="{{ old('description') }}" maxlength="1000" required="true" />
                                </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <x-admin.button variant="danger" data-bs-dismiss="modal" text="{{ __('Close') }}" />
                        <x-admin.button type="submit" text="{{ __('Send Mail') }}" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Banned modal -->

        <!-- Start Verify modal -->
        <div class="modal fade" id="verifyModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Send verify link to customer mail') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <p>{{ __('Are you sure want to send verify link to customer mail?') }}</p>

                            <form action="{{ route('admin.send-verify-request', $user->id) }}" method="POST">
                                @csrf

                        </div>
                    </div>
                    <div class="modal-footer">
                        <x-admin.button variant="danger" data-bs-dismiss="modal" text="{{ __('Close') }}" />
                        <x-admin.button type="submit" text="{{ __('Send Mail') }}" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Verify modal -->

        <!-- Start Send Mail modal -->
        <div class="modal fade" id="sendMailModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Send Mail To Customer') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form action="{{ route('admin.send-mail-to-customer', $user->id) }}" method="POST">
                                @csrf

                                <div class="form-group">
                                    <x-admin.form-input id="mail_send_subject" name="subject" label="{{ __('Subject') }}"
                                        placeholder="{{ __('Enter Subject') }}" value="{{ old('subject') }}"
                                        required="true" />
                                </div>

                                <div class="form-group">
                                    <x-admin.form-textarea id="mail_send_description" name="description" required="true"
                                        label="{{ __('Description') }}" placeholder="{{ __('Enter Description') }}"
                                        value="{{ old('description') }}" maxlength="1000" />
                                </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <x-admin.button variant="danger" data-bs-dismiss="modal" text="{{ __('Close') }}" />
                        <x-admin.button type="submit" text="{{ __('Send Mail') }}" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Send Mail modal -->
    @endadminCan


    @adminCan('customer.delete')
        <x-admin.delete-modal />
    @endadminCan
@endsection
