@extends('admin.master_layout')
@section('title')
    <title>{{ $title }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <x-admin.breadcrumb title="{{ $title }}" :list="[
                __('Dashboard') => route('admin.dashboard'),
                $title => '#',
            ]" />

            <div class="section-body">
                <div class="row">
                    {{-- Search filter --}}
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body p-0">
                                <form id="search_filter_form" action="{{ url()->current() }}" method="GET"
                                    class="card-body">
                                    <div class="row">
                                        <div class="col-md-{{ isRoute('admin.orders') ? '3' : '4' }} form-group mb-3 mb-md-0">
                                            <div class="input-group">
                                                <x-admin.form-input class="on-change-submit-filter_form" name="keyword" placeholder="{{ __('Search') }}"
                                                    value="{{ request()->get('keyword') }}" />
                                                <button class="btn btn-primary" type="submit"><i
                                                        class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                        <div class="col-md-{{ isRoute('admin.orders') ? '3' : '4' }} form-group mb-3 mb-md-0">
                                            <div class="input-group">
                                                <x-admin.form-input class="datepicker-two" name="from_date"
                                                    placeholder="{{ __('From Date') }}" value="{{ request('from_date') }}"
                                                    autocomplete="off" />
                                                <x-admin.form-input class="datepicker-two" name="to_date"
                                                    placeholder="{{ __('To Date') }}" value="{{ request('to_date') }}"
                                                    autocomplete="off" />
                                                <button class="btn btn-primary" type="submit"><i
                                                        class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                        <div class="col-md-2 form-group mb-3 mb-md-0">
                                            <x-admin.form-select name="user" id="user" class="select2 on-change-submit-filter_form">
                                                <x-admin.select-option value="" text="{{ __('Select Customer') }}" />
                                                @foreach ($users as $user)
                                                    <x-admin.select-option :selected="$user->id == request('user')" value="{{ $user?->id }}"
                                                        text="{{ $user?->name }} - ({{ $user?->email }})" />
                                                @endforeach
                                            </x-admin.form-select>
                                        </div>
                                        @if (isRoute('admin.orders'))
                                            <div class="col-md-2 form-group mb-3 mb-md-0">
                                                <x-admin.form-select class="form-select on-change-submit-filter_form" name="payment_status" id="payment_status">
                                                    <x-admin.select-option value=""
                                                        text="{{ __('Payment Status') }}" />
                                                    <x-admin.select-option :selected="request('payment_status') == 'success'" value="success"
                                                        text="{{ __('Success') }}" />
                                                    <x-admin.select-option :selected="request('payment_status') == 'pending'" value="pending"
                                                        text="{{ __('Pending') }}" />
                                                    <x-admin.select-option :selected="request('payment_status') == 'rejected'" value="rejected"
                                                        text="{{ __('Rejected') }}" />
                                                    <x-admin.select-option :selected="request('payment_status') == 'refund'" value="refund"
                                                        text="{{ __('Refund') }}" />
                                                </x-admin.form-select>
                                            </div>
                                        @endif
                                        <div
                                            class="col-md-1 form-group mb-3 mb-md-0">
                                            <x-admin.form-select  class="form-select on-change-submit-filter_form"
                                                name="order_by" id="order_by">
                                                <x-admin.select-option value="" text="{{ __('Order By') }}" />
                                                <x-admin.select-option :selected="request('order_by') == '1'" value="1"
                                                    text="{{ __('ASC') }}" />
                                                <x-admin.select-option :selected="request('order_by') == '0'" value="0"
                                                    text="{{ __('DESC') }}" />
                                            </x-admin.form-select>
                                        </div>
                                        <div
                                            class="col-md-1 form-group mb-3 mb-md-0">
                                            <x-admin.form-select class="form-select on-change-submit-filter_form"
                                                name="par-page" id="par-page">
                                                <x-admin.select-option value="" text="{{ __('Per Page') }}" />
                                                <x-admin.select-option :selected="request('par-page') == '5'" value="5"
                                                    text="{{ __('5') }}" />
                                                <x-admin.select-option :selected="request('par-page') == '10'" value="10"
                                                    text="{{ __('10') }}" />
                                                <x-admin.select-option :selected="request('par-page') == '25'" value="25"
                                                    text="{{ __('25') }}" />
                                                <x-admin.select-option :selected="request('par-page') == '50'" value="50"
                                                    text="{{ __('50') }}" />
                                                <x-admin.select-option :selected="request('par-page') == '100'" value="100"
                                                    text="{{ __('100') }}" />
                                                <x-admin.select-option :selected="request('par-page') == 'all'" value="all"
                                                    text="{{ __('All') }}" />
                                            </x-admin.form-select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th>{{ __('SN') }}</th>
                                            <th>{{ __('User') }}</th>
                                            <th>{{ __('Order Id') }}</th>
                                            <th>{{ __('Paid Amount') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Payment') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>

                                        @forelse ($orders as $index => $order)
                                            <tr>
                                                <td>{{ ++$index }}</td>
                                                <td><a target="_blank"
                                                        href="{{ route('admin.customer-show', $order->user_id) }}">{{ $order?->user?->name }}</a>
                                                </td>
                                                <td>#{{ $order->order_id }}</td>
                                                <td>{{ specific_currency_with_icon($order->payable_currency, $order->paid_amount) }}
                                                </td>

                                                <td>
                                                    <div
                                                        class="badge badge-{{ \App\Enums\OrderStatus::getColor($order->order_status) }}">
                                                        {{ \App\Enums\OrderStatus::getLabel($order->order_status) }}</div>
                                                </td>

                                                <td>
                                                    <div
                                                        class="badge badge-{{ \App\Enums\OrderStatus::getColor($order->payment_status) }}">
                                                        {{ \App\Enums\OrderStatus::getLabel($order->payment_status) }}
                                                    </div>
                                                </td>



                                                <td>
                                                    <a href="{{ route('admin.order', $order->order_id) }}"
                                                        class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                                                    @if ($order->payment_status != 'success')
                                                        <a href=""
                                                            data-url="{{ route('admin.order-delete', $order->id) }}"
                                                            class="btn btn-danger btn-sm delete"><i
                                                                class="fa fa-trash"></i></a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <x-empty-table :name="__('Customer')" route="" create="no"
                                                :message="__('No data found!')" colspan="7"></x-empty-table>
                                        @endforelse
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <x-admin.delete-modal />
@endsection
@push('js')
    <script>
        $(function() {
            'use strict'

            $('.delete').on('click', function(e) {
                e.preventDefault();
                const modal = $('#deleteModal');
                modal.find('form').attr('action', $(this).data('url'));
                modal.modal('show');
            })
        })

        "use strict"

        function changeStatus(event, id) {
            var isDemo = "{{ config('app.app_mode') ?? 'LIVE' }}"
            if (isDemo == 'DEMO') {
                toastr.error("{{ __('This Is Demo Version. You Can Not Change Anything') }}");
                return;
            }
            $.ajax({
                type: "put",
                data: {
                    _token: '{{ csrf_token() }}',
                    status: event.target.value,
                },
                url: "{{ url('/admin/orders/status-update') }}" + "/" + id,
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                    } else {
                        toastr.warning(response.message);
                    }
                },
                error: function(err) {
                    console.log(err);
                }
            });
        }
    </script>
@endpush
