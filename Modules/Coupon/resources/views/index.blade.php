@extends('admin.master_layout')
@section('title')
    <title>{{ __('Coupon List') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <x-admin.breadcrumb title="{{ __('Coupon List') }}" :list="[
                __('Dashboard') => route('admin.dashboard'),
                __('Coupon List') => '#',
            ]" />

            <div class="section-body">
                <div class="row mt-sm-4">
                    <div class="col-12">
                        <div class="card ">
                            <div class="card-header d-flex justify-content-between">
                                <x-admin.form-title :text="__('Coupon List')" />
                                <div>
                                    <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#create_coupon_id" class="btn btn-primary"><i
                                        class="fas fa-plus"></i> {{ __('Add New') }}</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive table-invoice">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{ __('SN') }}</th>
                                                <th>{{ __('Coupon Code') }}</th>
                                                <th>{{ __('Min Price') }}</th>
                                                <th>{{ __('Discount') }}</th>
                                                <th>{{ __('Start time') }}</th>
                                                <th>{{ __('End time') }}</th>
                                                <th>{{ __('Status') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($coupons as $index => $coupon)
                                                <tr>
                                                    <td>{{ ++$index }}</td>
                                                    <td>{{ $coupon->coupon_code }}</td>
                                                    <td>{{ currency($coupon->min_price) }}</td>
                                                    <td> 
                                                        {{ $coupon?->discount_type == 'percentage' ? $coupon?->discount . '%' : currency($coupon?->discount) }}
                                                    </td>

                                                    <td>{{ formattedDate($coupon->start_date) }}</td>
                                                    <td>{{ formattedDate($coupon->expired_date) }}</td>

                                                    <td>
                                                        <input class="change-status" data-href="{{route('admin.coupon.status-update',$coupon->id)}}"
                                                        id="status_toggle" type="checkbox"
                                                        {{ $coupon->status == 'active' ? 'checked' : '' }} data-toggle="toggle"
                                                        data-onlabel="{{ __('Active') }}" data-offlabel="{{ __('Inactive') }}"
                                                        data-onstyle="success" data-offstyle="danger">
                                                    </td>

                                                    <td>

                                                        <a href="javascript:;" data-bs-toggle="modal"
                                                            data-bs-target="#edit_coupon_id_{{ $coupon->id }}"
                                                            class="btn btn-warning btn-sm"><i class="fa fa-edit"
                                                                aria-hidden="true"></i></a>
                                                            <a href="{{ route('admin.coupon.destroy', $coupon->id) }}"
                                                                data-modal="#deleteModal" class="delete-btn btn btn-danger btn-sm"><i
                                                                    class="fa fa-trash" aria-hidden="true"></i></a>

                                                    </td>

                                                </tr>
                                            @empty
                                                <x-empty-table :name="__('Coupon')" route="" create="no"
                                                    :message="__('No data found!')" colspan="8"></x-empty-table>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @foreach ($coupons as $index => $coupon)
        <div class="modal fade" id="edit_coupon_id_{{ $coupon->id }}" tabindex="-1" role="dialog"
            aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Create Coupon') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form action="{{ route('admin.coupon.update', $coupon->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <x-admin.form-input name="coupon_code" label="{{ __('Coupon Code') }}" placeholder="{{ __('Enter Coupon Code') }}" value="{{ $coupon->coupon_code }}" required="true"/>
                                </div>

                                <div class="form-group">
                                    <x-admin.form-input type="number"  name="min_price" label="{{ __('Minimum purchase price') }}" placeholder="{{ __('Enter Minimum purchase price') }}" value="{{ $coupon->min_price }}" required="true"/>
                                </div>

                                <div class="form-group">
                                    <x-admin.form-input  name="discount" label="{{ __('Discount') }}" placeholder="{{ __('Enter Discount') }}" value="{{ $coupon->discount }}" required="true"/>
                                </div>
                                <div class="form-group">
                                    <x-admin.form-select name="discount_type" id="discount_type_edit" class="form-select" label="{{ __('Discount Type') }} ">
                                        <x-admin.select-option :selected="'percentage' == $coupon->discount_type" value="percentage" text="{{ __('Percentage') }}" />
                                        <x-admin.select-option :selected="'amount' == $coupon->discount_type" value="amount" text="{{ __('Amount') }}" />
                                    </x-admin.form-select>
                                </div>

                                <div class="form-group">
                                    <x-admin.form-input class="datepicker"  name="start_date" label="{{ __('Start time') }}" placeholder="{{ __('Enter Start time') }}" value="{{ $coupon->start_date }}" required="true"/>
                                </div>
                                <div class="form-group">
                                    <x-admin.form-input class="datepicker"  name="expired_date" label="{{ __('End time') }}" placeholder="{{ __('Enter End time') }}" value="{{ $coupon->expired_date }}" required="true"/>
                                </div>

                                <div class="form-group">
                                    <x-admin.form-switch name="status" label="{{ __('Status') }}" active_value="active" inactive_value="inactive" :checked="$coupon->status == 'active'"/>
                                </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <x-admin.button variant="danger" data-bs-dismiss="modal" text="{{__('Close')}}"/>
                        <x-admin.button type="submit" text="{{__('Update')}}"/>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach


    <!-- Modal -->
    <div class="modal fade" id="create_coupon_id" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Create Coupon') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form action="{{ route('admin.coupon.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <x-admin.form-input id="create_coupon_code"  name="coupon_code" label="{{ __('Coupon Code') }}" placeholder="{{ __('Enter Coupon Code') }}" required="true"/>
                            </div>

                            <div class="form-group">
                                <x-admin.form-input type="number"  name="min_price" label="{{ __('Minimum purchase price') }}" placeholder="{{ __('Enter Minimum purchase price') }}" required="true"/>
                            </div>

                            <div class="form-group">
                                <x-admin.form-input  name="discount" label="{{ __('Discount') }}" placeholder="{{ __('Enter Discount') }}" required="true"/>
                            </div>
                            <div class="form-group">
                                <x-admin.form-select name="discount_type" id="discount_type" class="form-select" label="{{ __('Discount Type') }} ">
                                    <x-admin.select-option :selected="'percentage' == old('discount_type')" value="percentage" text="{{ __('Percentage') }}" />
                                    <x-admin.select-option :selected="'amount' == old('discount_type')" value="amount" text="{{ __('Amount') }}" />
                                </x-admin.form-select>
                            </div>

                            <div class="form-group">
                                <x-admin.form-input class="datepicker"  name="start_date" label="{{ __('Start time') }}" placeholder="{{ __('Enter Start time') }}" required="true"/>
                            </div>
                            <div class="form-group">
                                <x-admin.form-input class="datepicker"  name="expired_date" label="{{ __('End time') }}" placeholder="{{ __('Enter End time') }}" required="true"/>
                            </div>

                            <div class="form-group">
                                <x-admin.form-switch name="status" label="{{ __('Status') }}" active_value="active" inactive_value="inactive" :checked="old('status') == 'active'"/>
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <x-admin.button variant="danger" data-bs-dismiss="modal" text="{{__('Close')}}"/>
                    <x-admin.button type="submit" text="{{__('Save')}}"/>
                </div>
                </form>
            </div>
        </div>
    </div>


    <x-admin.delete-modal />
@endsection
