@extends('admin.master_layout')
@section('title')
    <title>{{ __('Refund Request') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <x-admin.breadcrumb title="{{ __('Refund Request') }}" :list="[
                __('Dashboard') => route('admin.dashboard'),
                __('Refund Request') => '#',
            ]" />

            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">

                                        <tr>
                                            <td>{{ __('User') }}</td>
                                            <td><a
                                                    href="{{ route('admin.customer-show', $refund_request?->user_id) }}">{{ $refund_request?->user?->name }}</a>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>{{ __('Order ID') }}</td>
                                            <td>#<a target="_blank"
                                                    href="{{ route('admin.order', $refund_request?->order?->order_id) }}">{{ $refund_request?->order?->order_id }}</a>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>{{ __('Reason') }}</td>
                                            <td>{!! nl2br($refund_request?->reason) !!}</td>
                                        </tr>

                                        <tr>
                                            <td>{{ __('Request Payment Method') }}</td>
                                            <td>{!! nl2br($refund_request?->method) !!}</td>
                                        </tr>

                                        <tr>
                                            <td>{{ __('Account information for received amount') }}</td>
                                            <td>{!! nl2br($refund_request?->account_information) !!}</td>
                                        </tr>

                                        @if ($refund_request?->status == 'success')
                                            <tr>
                                                <td>{{ __('Refund amount') }}</td>
                                                <td>{{ currency($refund_request?->refund_amount) }}</td>
                                            </tr>
                                        @endif

                                        <tr>
                                            <td>{{ __('Status') }}</td>
                                            <td>
                                                @if ($refund_request?->status == 'success')
                                                    <div class="badge bg-success">{{ __('Success') }}</div>
                                                @elseif ($refund_request?->status == 'rejected')
                                                    <div class="badge bg-danger">{{ __('Rejected') }}</div>
                                                @else
                                                    <div class="badge bg-info">{{ __('Pending') }}</div>
                                                @endif
                                            </td>
                                        </tr>

                                    </table>
                                </div>

                                @if ($refund_request?->status == 'pending')
                                    <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#rejectRefund"
                                        class="btn btn-dark">{{ __('Make refund rejected') }}</a>
                                @endif

                                @if ($refund_request?->status == 'rejected' || $refund_request?->status == 'pending')
                                    <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#approveRefund"
                                        class="btn btn-success">{{ __('Make approved refund') }}</a>
                                @endif

                                <a href=""
                                    data-url="{{ route('admin.delete-refund-request', $refund_request?->id) }}"
                                    class="btn btn-danger delete">{{ __('Delete request') }}</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- delete modal --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="delete">
        <div class="modal-dialog" role="document">
            <form action="" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Delete refund request') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-danger">{{ __('Are You Sure to Delete this refund ?') }}</p>
                    </div>
                    <div class="modal-footer">
                        <x-admin.button variant="danger" data-bs-dismiss="modal" text="{{ __('Close') }}" />
                        <x-admin.button type="submit" text="{{ __('Yes, Delete') }}" />
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!--Refund Approved Modal -->
    <div class="modal fade" id="approveRefund" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Refund Approval') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        @php
                            $currency = allCurrencies()->where('is_default', 'yes')->first();
                        @endphp
                        <form action="{{ route('admin.approved-refund-request', $refund_request?->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="">{{ __('Refund Amount') }} <span data-toggle="tooltip"
                                        data-placement="top" class="fa fa-info-circle text--primary"
                                        title="{{ __('Amount should be') }} {{ $currency?->currency_code }}({{ $currency?->currency_icon }})"> <span class="text-danger">*</span></label>
                                <input type="text" name="refund_amount" class="form-control" autocomplete="off">
                                <div class="form-group">
                                    <label for="admin_response">{{ __('Note') }} <span class="text-danger">*</span></label>
                                    <textarea id="admin_response" name="admin_response" class="form-control text-area-5" cols="30" rows="10">{{ old('admin_response') }}</textarea>
                                </div>
                            </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <x-admin.button variant="danger" data-bs-dismiss="modal" text="{{ __('Close') }}" />
                    <x-admin.button type="submit" text="{{ __('Send Mail') }}" />
                </div>
                </form>
            </div>
        </div>
    </div>

    <!--Payment Refund Modal -->
    <div class="modal fade" id="rejectRefund" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Refund Reject') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form action="{{ route('admin.reject-refund-request', $refund_request?->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="admin_response">{{ __('Note') }} <span class="text-danger">*</span></label>
                                <textarea id="admin_response" name="admin_response" class="form-control text-area-5" cols="30" rows="10">{{ old('admin_response') }}</textarea>
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <x-admin.button variant="danger" data-bs-dismiss="modal" text="{{ __('Close') }}" />
                    <x-admin.button type="submit" text="{{ __('Send Mail') }}" />
                </div>
                </form>
            </div>
        </div>
    </div>




    @push('js')
        <script>
            $(function() {
                'use strict'

                $('.delete').on('click', function(e) {
                    e.preventDefault();
                    const modal = $('#delete');
                    modal.find('form').attr('action', $(this).data('url'));
                    modal.modal('show');
                })
            })
        </script>
    @endpush
@endsection
