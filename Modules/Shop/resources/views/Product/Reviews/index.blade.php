@extends('admin.master_layout')
@section('title')
    <title>{{ __('Product Reviews') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <x-admin.breadcrumb title="{{ __('Product Reviews') }}" :list="[
                __('Dashboard') => route('admin.dashboard'),
                __('Product Reviews') => '#',
            ]" />
            <div class="section-body">
                <div class="mt-4 row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form class="on-change-submit"
                                    action="{{ route('admin.update-general-setting') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <label class="d-flex align-items-center mb-0">
                                        <input type="hidden" value="inactive" name="review_auto_approved"
                                            class="custom-switch-input">
                                        <input {{ $setting->review_auto_approved == 'active' ? 'checked' : '' }}
                                            type="checkbox" value="active" name="review_auto_approved"
                                            class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                        <span
                                            class="custom-switch-description">{{ __('Product Review Auto Approved') }}</span>
                                    </label>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4>{{ __('Product Reviews') }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive max-h-400">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th width="5%">{{ __('SN') }}</th>
                                                <th width="30%">{{ __('Review') }}</th>
                                                <th width="15%">{{ __('Product') }}</th>
                                                <th width="10%">{{ __('Author') }}</th>
                                                <th width="10%">{{ __('Email') }}</th>
                                                <th width="15%">{{ __('Status') }}</th>
                                                <th width="15%">{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($reviews as $review)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>
                                                        @for ($i = 0; $i < 5; $i++)
                                                            <i
                                                                class="text-warning {{ $i < $review?->rating ? 'fas fa-star' : 'far fa-star' }}"></i>
                                                        @endfor
                                                        <br>
                                                        {{ Str::limit($review->review, 50) }}
                                                    </td>
                                                    <td>{{ $review?->product?->title }}</td>

                                                    <td>
                                                        {{ $review->name }}
                                                    </td>
                                                    <td>
                                                        {{ $review->email }}
                                                    </td>

                                                    <td>
                                                        <input class="change-status" data-href="{{route('admin.product-review.status-update',$review->id)}}"
                                                            id="status_toggle" type="checkbox"
                                                            {{ $review->status ? 'checked' : '' }} data-toggle="toggle"
                                                            data-onlabel="{{ __('Active') }}"
                                                            data-offlabel="{{ __('Inactive') }}" data-onstyle="success"
                                                            data-offstyle="danger">
                                                    </td>
                                                    <td>
                                                        <x-admin.edit-button :href="route(
                                                            'admin.product-review.show',
                                                            $review?->product?->id,
                                                        )" />
                                                        <a href="{{ route('admin.product-review.destroy', $review->id) }}"
                                                            data-modal="#deleteModal"
                                                            class="delete-btn btn btn-danger btn-sm"><i class="fa fa-trash"
                                                                aria-hidden="true"></i></a>
                                                </tr>
                                            @empty
                                                <x-empty-table :name="__('Product Reviews')" route="admin.product-review.index"
                                                    create="no" :message="__('No data found!')" colspan="7"></x-empty-table>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $reviews->links() }}
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