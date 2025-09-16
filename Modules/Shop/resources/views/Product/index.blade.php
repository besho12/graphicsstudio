@extends('admin.master_layout')
@section('title')
    <title>
        {{ __('Product List') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <x-admin.breadcrumb title="{{ __('Product List') }}" :list="[
                __('Dashboard') => route('admin.dashboard'),
                __('Product List') => '#',
            ]" />
            <div class="section-body">
                <div class="mt-4 row">
                    {{-- Search filter --}}
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.product.index') }}" method="GET"
                                    class="on-change-submit card-body">
                                    <div class="row">
                                        <div class="col-md-4 form-group mb-3 mb-md-0">
                                            <div class="input-group">
                                                <input type="text" name="keyword" value="{{ request()->get('keyword') }}"
                                                    class="form-control" placeholder="{{ __('Search') }}">
                                                <button class="btn btn-primary" type="submit"><i
                                                        class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                        <div class="col-md-2 form-group mb-3 mb-md-0">
                                            <select name="is_popular" id="is_popular" class="form-control form-select">
                                                <option value="">{{ __('Select Popular') }}</option>
                                                <option value="1" {{ request('is_popular') == '1' ? 'selected' : '' }}>
                                                    {{ __('Yes') }}
                                                </option>
                                                <option value="0" {{ request('is_popular') == '0' ? 'selected' : '' }}>
                                                    {{ __('No') }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 form-group mb-3 mb-md-0">
                                            <select name="status" id="status" class="form-control form-select">
                                                <option value="">{{ __('Select Status') }}</option>
                                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>
                                                    {{ __('Active') }}
                                                </option>
                                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>
                                                    {{ __('In-Active') }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 form-group mb-3 mb-md-0">
                                            <select name="order_by" id="order_by" class="form-control form-select">
                                                <option value="">{{ __('Order By') }}</option>
                                                <option value="1" {{ request('order_by') == '1' ? 'selected' : '' }}>
                                                    {{ __('ASC') }}
                                                </option>
                                                <option value="0" {{ request('order_by') == '0' ? 'selected' : '' }}>
                                                    {{ __('DESC') }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 form-group mb-3 mb-md-0">
                                            <select name="par-page" id="par-page" class="form-control form-select">
                                                <option value="">{{ __('Per Page') }}</option>
                                                <option value="10" {{ '10' == request('par-page') ? 'selected' : '' }}>
                                                    {{ __('10') }}
                                                </option>
                                                <option value="50" {{ '50' == request('par-page') ? 'selected' : '' }}>
                                                    {{ __('50') }}
                                                </option>
                                                <option value="100"
                                                    {{ '100' == request('par-page') ? 'selected' : '' }}>
                                                    {{ __('100') }}
                                                </option>
                                                <option value="all"
                                                    {{ 'all' == request('par-page') ? 'selected' : '' }}>
                                                    {{ __('All') }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4>{{ __('Product List') }}</h4>
                                <div>
                                    @if ($un_used_files)
                                        <a href="{{route('admin.product.delete-used-files')}}" class="btn btn-warning">
                                            {{__('Clear Unused Files')}} <span class="badge badge-danger">{{$un_used_files}}</span>
                                          </a>
                                    @endif
                                    <x-admin.add-button href="javascript:;" data-bs-toggle="modal"
                                        data-bs-target="#create_modal" />
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive max-h-400">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th width="5%">{{ __('SN') }}</th>
                                                <th width="10%">{{ __('Image') }}</th>
                                                <th width="15%">{{ __('Title') }}</th>
                                                <th width="10%">{{ __('SKU') }}</th>
                                                <th width="7%">{{ __('Quantity') }}</th>
                                                <th width="13%">{{ __('Category') }}</th>
                                                <th width="10%">{{ __('Price') }}</th>
                                                <th width="10%">{{ __('Popular') }}</th>
                                                <th width="10%">{{ __('Status') }}</th>
                                                <th width="10%">{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($products as $product)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td><img src="{{ asset($product->image) }}"
                                                            alt="{{ $product->title }}" class="rounded-circle my-2"></td>
                                                    <td><a target="_blank"
                                                            href="{{ route('single.product', $product?->slug) }}">{{ $product?->title }}</a>
                                                    </td>
                                                    <td>{{ $product->sku }}</td>
                                                    <td>{{ $product->qty }}</td>
                                                    <td>
                                                        <p class="position-relative">{{ $product?->category?->title }}
                                                            @if ($product?->category?->status == 0)
                                                                <span
                                                                    class="badge badge-warning position-absolute category-badge fs-6">{{ __('Inactive') }}</span>
                                                            @endif
                                                        </p>
                                                    </td>
                                                    <td>{{ currency($product?->price) }}</td>
                                                    <td>
                                                        @if ($product->is_popular == 1)
                                                            <span class="badge badge-success">{{ __('Yes') }}</span>
                                                        @else
                                                            <span class="badge badge-danger">{{ __('No') }}</span>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        <input class="change-status"
                                                            data-href="{{ route('admin.product.status-update', $product->id) }}"
                                                            id="status_toggle" type="checkbox"
                                                            {{ $product->status ? 'checked' : '' }} data-toggle="toggle"
                                                            data-onlabel="{{ __('Active') }}"
                                                            data-offlabel="{{ __('Inactive') }}" data-onstyle="success"
                                                            data-offstyle="danger">
                                                    </td>
                                                    <td>
                                                        <x-admin.edit-button :href="route('admin.product.edit', [
                                                            'product' => $product->id,
                                                            'code' => getSessionLanguage(),
                                                        ])" />
                                                        <a href="{{ route('admin.product.destroy', $product->id) }}"
                                                            data-modal="#deleteModal"
                                                            class="delete-btn btn btn-danger btn-sm"><i class="fa fa-trash"
                                                                aria-hidden="true"></i></a>
                                                        @if ($product->type == Modules\Shop\app\Models\Product::DIGITAL_TYPE)
                                                            <a
                                                                href="{{ route('admin.product.file-download', $product->slug) }}"class="btn btn-success btn-sm"><i
                                                                    class="fa fa-download"></i></a>
                                                        @endif
                                                </tr>
                                            @empty
                                                <x-empty-table :name="__('Product')" route="admin.product.create" create="yes"
                                                    :message="__('No data found!')" colspan="10"></x-empty-table>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                @if (request()->get('par-page') !== 'all')
                                    <div class="float-right">
                                        {{ $products->onEachSide(0)->links() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <x-admin.delete-modal />
    <div class="modal fade" id="create_modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form action="{{ route('admin.product.create') }}" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Type') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pb-0">
                    <div class="container-fluid">
                        <x-admin.form-select name="type" id="type" class="form-select" required="true">
                            @foreach (Modules\Shop\app\Models\Product::getTypes() as $key => $value)
                                <x-admin.select-option :selected="$key == old('type')" value="{{ $key }}"
                                    text="{{ $value }}" />
                            @endforeach
                        </x-admin.form-select>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <x-admin.button type="submit" variant="success" text="{{ __('Continue') }}" />
                </div>
            </form>
        </div>
    </div>
@endsection
