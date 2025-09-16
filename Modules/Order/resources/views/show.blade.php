@extends('admin.master_layout')
@section('title')
    <title>{{ __('Order Details') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <x-admin.breadcrumb title="{{ __('Order Details') }}" :list="[
                __('Dashboard') => route('admin.dashboard'),
                __('Order Details') => '#',
            ]" />

            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive text-center">
                                    <table class="table table-striped">
                                        <tr>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Payment Status') }}</th>
                                            @if (checkAdminHasPermission('order.management'))
                                                <th>{{ __('Status') }}</th>
                                            @endif
                                        </tr>

                                        <tr>
                                            <td><a
                                                    href="{{ route('admin.customer-show', $order->user_id) }}">{{ $order?->user?->name }}</a>
                                            <td>
                                                <div
                                                    class="badge badge-{{ \App\Enums\OrderStatus::getColor($order->payment_status) }}">
                                                    {{ \App\Enums\OrderStatus::getLabel($order->payment_status) }}</div>
                                            </td>
                                            @if (checkAdminHasPermission('order.management'))
                                                <td class="d-flex justify-content-center align-items-center">
                                                    <select data-id="{{ $order->id }}"
                                                        class="w-25 form-control order-status form-select">
                                                        <option {{ $order->order_status == 'draft' ? 'selected' : '' }}
                                                            value="draft">{{ __('Draft') }}</option>
                                                        <option {{ $order->order_status == 'pending' ? 'selected' : '' }}
                                                            value="pending">{{ __('Pending') }}</option>
                                                        <option {{ $order->order_status == 'process' ? 'selected' : '' }}
                                                            value="process">{{ __('Process') }}</option>
                                                        <option {{ $order->order_status == 'success' ? 'selected' : '' }}
                                                            value="success">{{ __('completed') }}</option>
                                                    </select>
                                                </td>
                                            @endif

                                        </tr>

                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="section-body">
                <div class="invoice">
                    <div class="invoice-print" id="order_invoice_print">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="invoice-title">
                                    <h2>{{ __('Invoice') }}</h2>
                                    <div class="invoice-number">{{ __('Order Id') }}: #{{ $order->order_id }}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <table class="table">
                                        <tr>
                                            <td class="px-3">
                                                <address>
                                                    <strong>{{ __('Billed To') }}:</strong><br>
                                                    {{ $order?->order_address->billing_first_name . ' ' . $order?->order_address->billing_last_name }}<br>
                                                    {{ $order?->order_address->billing_email }}<br>
                                                    {{ $order?->order_address->billing_phone }}<br>
                                                    {{ $order?->order_address->billing_address }}<br>
                                                    {{ $order?->order_address->billing_city }},
                                                    {{ $order?->order_address->billing_state }},
                                                    {{ $order?->order_address->billing_country }}
                                                </address>
                                                <strong>{{ __('Payment Method') }}:</strong><br>
                                                <span
                                                    class=" text-capitalize">{{ str_replace('_', ' ', $order?->payment_method) }}</span>
                                                <address>
                                                    <strong>{{ __('Transaction Id') }}:</strong><br>
                                                    {{ $order->transaction_id }}<br>
                                                </address>
                                            </td>

                                            <td class="px-3 text-right">
                                                <address>
                                                    <strong>{{ __('Shipped To') }}:</strong><br>
                                                    {{ $order?->order_address->shipping_first_name . ' ' . $order?->order_address->shipping_last_name }}<br>
                                                    {{ $order?->order_address->shipping_email }}<br>
                                                    {{ $order?->order_address->shipping_phone }}<br>
                                                    {{ $order?->order_address->shipping_address }}<br>
                                                    {{ $order?->order_address->shipping_city }},
                                                    {{ $order?->order_address->shipping_state }},
                                                    {{ $order?->order_address->shipping_country }}
                                                </address>
                                                <address>
                                                    <strong>{{ __('Order Date') }}:</strong><br>
                                                    {{ formattedDate($order->created_at) }}<br><br>
                                                </address>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="section-title">{{ __('Order Summary') }}</div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover table-md">
                                        <tbody>
                                            <tr>
                                                <th width="5%">#</th>
                                                <th class="text-center">{{ __('Product Name') }}</th>
                                                <th class="text-center">{{ __('Quantity') }}</th>
                                                <th class="text-right">{{ __('Unit Price') }}</th>
                                                <th class="text-right">{{ __('Total Amount') }}</th>
                                            </tr>
                                            @foreach ($order?->order_products as $key => $product)
                                                <tr>
                                                    <td width="5%">{{ $key + 1 }}</td>
                                                    <td class="text-center">{{ $product->product_name }}</td>
                                                    <td class="text-center">{{ $product->qty }}</td>
                                                    <td class="text-right">
                                                        {{ specific_currency_with_icon($order->payable_currency, $product->unit_price) }}
                                                    </td>
                                                    <td class="text-right">
                                                        {{ specific_currency_with_icon($order->payable_currency, $product->total) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-lg-12 text-end">
                                        <div>{{ __('Sub Total') }}: <strong
                                                class="ml-3 d-inline-block price-box">{{ specific_currency_with_icon($order->payable_currency, $order->sub_total) }}</strong>
                                        </div>

                                        <div>{{ __('Discount') }}: <strong class="ml-3 d-inline-block price-box">(-)
                                                {{ specific_currency_with_icon($order->payable_currency, $order->discount) }}</strong>
                                        </div>

                                        <div>{{ __('Tax') }}: <strong
                                                class="ml-3 d-inline-block price-box">{{ specific_currency_with_icon($order->payable_currency, $order->order_tax) }}</strong>
                                        </div>

                                        <div>{{ __('Delivery Charge') }}: <strong
                                                class="ml-3 d-inline-block price-box">{{ $order->delivery_charge > 0 ? specific_currency_with_icon($order->payable_currency, $order->delivery_charge) : __('Free') }}</strong>
                                        </div>
                                        <div>{{ __('Gateway Charge') }}: <strong
                                                class="ml-3 d-inline-block price-box">{{ specific_currency_with_icon($order->payable_currency, $order?->gateway_charge) }}</strong>
                                        </div>

                                        <hr>

                                        <div>{{ __('Total Payment') }}: <strong
                                                class="ml-3 d-inline-block price-box">{{ specific_currency_with_icon($order->payable_currency, $order->paid_amount) }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="text-md-right">
                        <div class="float-lg-left mb-lg-0 mb-3">
                            @if (checkAdminHasPermission('order.management'))
                                @if ($order->payment_status == 'pending')
                                    <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#rejectPayment"
                                        class="btn btn-danger btn-icon icon-left"><i class="fas fa-credit-card"></i>
                                        {{ __('Make reject payment') }}</a>
                                @endif

                                @if ($order->payment_status == 'rejected' || $order->payment_status == 'pending')
                                    <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#approvePayment"
                                        class="btn btn-primary btn-icon icon-left"><i class="fas fa-credit-card"></i>
                                        {{ __('Make approved payment') }}</a>
                                @endif
                                @if ($order->payment_status != 'success')
                                    <a href="" class="btn btn-danger btn-icon icon-left delete"
                                        data-url="{{ route('admin.order-delete', $order->id) }}"><i
                                            class="fas fa-times"></i>
                                        {{ __('Delete Order') }}</a>
                                @endif
                            @endif

                            <button class="btn btn-warning btn-icon icon-left" id="printInvoiceBtn"><i
                                    class="fas fa-print"></i>
                                {{ __('Print') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @if (checkAdminHasPermission('order.management'))
        @if ($order->payment_status != 'success')
            <x-admin.delete-modal />
        @endif

        <!--Order Status Modal -->
        <div class="modal fade" id="orderStatusUpdate" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Order Status Update') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form action="{{ route('admin.order.status-update', $order->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="order_status" id="order_status">
                                <p>{{ __('Are you sure you want to update the order status?') }}</p>
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

        <!--Payment Reject Modal -->
        <div class="modal fade" id="rejectPayment" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Payment Reject') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form action="{{ route('admin.order-payment-reject', $order->id) }}" method="POST">
                                @csrf
                                <p>{{ __('Are you sure you want to reject the order payment?') }}</p>
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

        <!--Payment Approved Modal -->
        <div class="modal fade" id="approvePayment" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Payment Approved') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form action="{{ route('admin.order-payment-approved', $order->id) }}" method="POST">
                                @csrf
                                <p>{{ __('Are you sure you want to approved the order payment?') }}</p>
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
    @endif

@endsection
@push('css')
    <style>
        .price-box {
            min-width: 120px;
        }

        .invoice hr {
            margin: 1rem 0;
            border-top-color: rgba(0, 0, 0, .1);
        }
    </style>
@endpush

@push('js')
    <script>
        @if ($order->payment_status != 'success')
            $(function() {
                'use strict'

                $('.delete').on('click', function(e) {
                    e.preventDefault();
                    const modal = $('#deleteModal');
                    modal.find('form').attr('action', $(this).data('url'));
                    modal.modal('show');
                })
            })
        @endif

        $(document).ready(function() {
            var originalStatus = "{{ $order->order_status }}"
            $('#orderStatusUpdate').on('hidden.bs.modal', function() {
                $('.order-status').val(originalStatus);
            });

            $(document).on("change", ".order-status", function(e) {
                e.preventDefault();
                $('#order_status').val(event.target.value);
                $('#orderStatusUpdate').modal('show');
            });

            $(document).on("click", "#printInvoiceBtn", function(e) {
                let body = document.body.innerHTML;
                let data = document.getElementById('order_invoice_print').innerHTML;
                document.body.innerHTML = data;
                window.print();
                document.body.innerHTML = body;
            });
        });
    </script>
@endpush
