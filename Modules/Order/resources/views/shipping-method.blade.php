@extends('admin.master_layout')
@section('title')
    <title>{{ __('Shipping Type') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <x-admin.breadcrumb title="{{ __('Shipping Type') }}" :list="[
                __('Dashboard') => route('admin.dashboard'),
                __('Shipping Type') => '#',
            ]" />
            <div class="section-body row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="lang_list_top">
                                <ul class="lang_list">
                                    @foreach ($languages = allLanguages() as $language)
                                        <li><a id="{{ request('code') == $language->code ? 'selected-language' : '' }}"
                                                href="{{ route('admin.shipping-method.index', ['code' => $language->code]) }}"><i
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
                                <h4>{{ __('Shipping Type') }}</h4>
                                @adminCan('shipping.method.management')
                                    <div>
                                        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#itemModal"
                                            class="btn btn-primary"><i class="fa fa-plus"></i> {{ __('Add New') }}</a>
                                    </div>
                                @endadminCan
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th width="5%">{{ __('SN') }}</th>
                                                <th>{{ __('Title') }}</th>
                                                <th>{{ __('Fee') }}</th>
                                                <th>{{ __('Free') }}</th>
                                                <th>{{ __('Minimum Order') }}</th>
                                                @adminCan('shipping.method.management')
                                                    <th>{{ __('Default') }}</th>
                                                    <th>{{ __('Status') }}</th>
                                                    <th width="10%">{{ __('Action') }}</th>
                                                @endadminCan
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($methods as $item)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>{{ $item?->getTranslation($code)?->title }}</td>
                                                    <td>{{ $item?->fee }}</td>
                                                    <td>
                                                        <div
                                                            class="badge badge-{{ $item?->is_free == 1 ? 'success' : 'danger' }}">
                                                            {{ $item?->is_free == 1 ? __('Yes') : __('No') }}</div>
                                                    </td>
                                                    <td>{{ $item?->minimum_order }}</td>
                                                    @adminCan('shipping.method.management')
                                                        <td>
                                                            <a class="change-shipping-status" data-column="is_default"
                                                                data-href="{{ route('admin.shipping-method.status-update', $item->id) }}"
                                                                href="javascript:;">
                                                                <input class="self-default-{{ $item->id }} default-status"
                                                                    id="status_toggle" type="checkbox"
                                                                    {{ $item->is_default ? 'checked' : '' }}
                                                                    data-toggle="toggle" data-onlabel="{{ __('Active') }}"
                                                                    data-offlabel="{{ __('Inactive') }}" data-onstyle="success"
                                                                    data-offstyle="danger">

                                                            </a>
                                                        </td>
                                                        <td>
                                                            <input class="change-shipping-status" data-column="status"
                                                                data-href="{{ route('admin.shipping-method.status-update', $item->id) }}"
                                                                id="status_toggle" type="checkbox"
                                                                {{ $item->status ? 'checked' : '' }} data-toggle="toggle"
                                                                data-onlabel="{{ __('Active') }}"
                                                                data-offlabel="{{ __('Inactive') }}" data-onstyle="success"
                                                                data-offstyle="danger">
                                                        </td>
                                                        <td>
                                                            <a href="javascript:;" data-id="{{ $item->id }}"
                                                                data-title="{{ $item?->getTranslation($code)?->title }}"
                                                                data-fee="{{ $item?->fee }}"
                                                                data-is_free="{{ $item?->is_free }}"
                                                                data-minimum_order="{{ $item?->minimum_order }}"
                                                                data-status="{{ $item?->status }}"
                                                                class="btn btn-warning btn-sm editItemData"><i
                                                                    class="fa fa-edit" aria-hidden="true"></i></a>

                                                            <a href="{{ route('admin.shipping-method.destroy', $item->id) }}"
                                                                data-modal="#deleteModal"
                                                                class="delete-btn btn btn-danger btn-sm"><i class="fa fa-trash"
                                                                    aria-hidden="true"></i></a>
                                                        </td>
                                                    @endadminCan
                                                </tr>
                                            @empty
                                                <x-empty-table :name="__('Item')" route="" create="no"
                                                    :message="__('No data found!')" colspan="8"></x-empty-table>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $methods->onEachSide(0)->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @adminCan('shipping.method.management')
        <div tabindex="-1" role="dialog" id="itemModal" class="modal fade">
            <div class="modal-dialog" role="document">
                <form class="modal-content" id="ItemForm" action="{{ route('admin.shipping-method.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Add New') }}</h5>
                        <button type="button" class="btn-close itemModalClose" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="code" value="{{ request('code') ?? getSessionLanguage() }}">
                        <div class="form-group col-12">
                            <label>{{ __('Title') }} <span class="text-danger">*</span></label>
                            <input data-translate="true" type="text" id="itemTitle" class="form-control" name="title">
                        </div>
                        @if ($code == $languages->first()->code)
                            <div class="form-group col-12 itemFee-box">
                                <label>{{ __('Fee') }} <span class="text-danger">*</span></label>
                                <input data-translate="true" type="number" id="itemFee" class="form-control"
                                    name="fee">
                            </div>
                            <div class="form-group col-12 itemFree-box">
                                <label>{{ __('Free') }} <span class="text-danger">*</span></label>
                                <select name="is_free" class="form-control" id="itemFree">
                                    <option value="0">{{ __('No') }}</option>
                                    <option value="1">{{ __('Yes') }}</option>
                                </select>
                            </div>
                            <div class="form-group col-12 itemMinimumOrder-box">
                                <label>{{ __('Minimum Order') }}</label>
                                <input data-translate="true" type="number" id="itemMinimumOrder" class="form-control"
                                    name="minimum_order" value="0">
                            </div>
                            <div class="form-group col-12 itemStatus-box">
                                <label>{{ __('Status') }} <span class="text-danger">*</span></label>
                                <select name="status" class="form-control" id="itemStatus">
                                    <option value="1">{{ __('Active') }}</option>
                                    <option value="0">{{ __('In-Active') }}</option>
                                </select>
                            </div>
                        @endif

                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-danger itemModalClose">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
        <x-admin.delete-modal />
    @endadminCan
@endsection
@push('js')
    <script>
        @adminCan('shipping.method.management')
        "use strict"
        $(document).ready(function() {
            $(document).on("click", ".editItemData", function(e) {
                var lang = "{{ $languages->first()->code }}";
                $("#ItemForm").attr("action", "{{ url('/admin/shipping-method') }}" + '/' + $(this).data(
                    'id'));
                $("#itemModal .modal-title").text("{{ __('Edit') }}");
                $("#itemTitle").val($(this).data('title'));
                if (lang) {
                    $("#itemFee").val($(this).data('fee'));
                    $("#itemFree").val($(this).data('is_free')).trigger('change');
                    $("#itemMinimumOrder").val($(this).data('minimum_order'));
                    $("#itemStatus").val($(this).data('status')).trigger('change');
                } else {
                    $(".itemFee-box").remove();
                    $(".itemFree-box").remove();
                    $(".itemMinimumOrder-box").remove();
                    $(".itemStatus-box").remove();
                }

                $('#itemModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $('#itemModal').modal('show');
            });
            $('.itemModalClose').on('click', function() {
                $("#ItemForm").attr("action", "{{ url('/admin/shipping-method') }}");
                $("#itemModal .modal-title").text("{{ __('Add New Item') }}");
                $("#itemTitle").val('');
                $("#itemFee").val('');
                $("#itemFree").val(0).trigger('change');
                $("#itemMinimumOrder").val(0);
                $("#itemStatus").val(1).trigger('change');
                $('#itemModal').modal('hide');
            });
            $('#itemFree').on('change', function() {
                var is_free = $(this).val();
                if (is_free == 1) {
                    $("#itemFee").val(0).prop('type', 'hidden');
                    $(".itemFee-box label").addClass('d-none');
                } else {
                    $('#itemFee').prop('type', 'text');
                    $(".itemFee-box label").removeClass('d-none');
                }
            });

            $(document).on("change", ".change-shipping-status", function(e) {
                e.preventDefault();
                var url = $(this).data("href");
                var type = $(this).data("column");
                $.ajax({
                    type: "put",
                    data: {
                        _token: '{{ csrf_token() }}',
                        column: type
                    },
                    url: url,
                    success: function(response) {
                        if (response.status) {
                            toastr.success(response.message);
                            if (type == 'is_default') {
                                setTimeout(function() {
                                    window.location.reload();
                                }, 1000);
                            }
                        } else {
                            toastr.info(response.message);
                            if (!response.status) {
                                setTimeout(function() {
                                    window.location.reload();
                                }, 1000);
                            }
                        }
                    },
                    error: function(err) {
                        //
                    }
                })
            });
        });
        @endadminCan
    </script>
@endpush
