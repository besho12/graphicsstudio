@extends('admin.master_layout')
@section('title')
    <title>{{ __('Reviews') }}</title>
@endsection
@section('admin-content')
    <div class="main-content">
        <section class="section">
            <x-admin.breadcrumb title="{{ __('Reviews') }}" :list="[
                __('Dashboard') => route('admin.dashboard'),
                __('Product Reviews') => route('admin.product-review.index'),
                __('Reviews') => '#',
            ]" />
            <div class="section-body">
                <div class="mt-4 row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4>{{ __('Reviews') }}</h4>
                                <div>
                                    <a href="{{ route('admin.product-review.index') }}" class="btn btn-primary"><i
                                            class="fa fa-arrow-left"></i>{{ __('Back') }}</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card-body">
                                    <ul class="list-unstyled list-unstyled-border list-unstyled-noborder">
                                        @forelse ($reviews as $review)
                                            <li class="media">
                                                <img alt="image" class="mr-3 rounded-circle" width="70"
                                                    src="{{ asset($review->user->image) }}">
                                                <div class="media-body">
                                                    <div class="media-right">
                                                        @if ($review->status == 1)
                                                            <div class="text-primary">{{ __('Approved') }}</div>
                                                        @else
                                                            <div class="text-warning">{{ __('Pending') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="mb-1 media-title">{{ $review->name }}</div>
                                                    <div class="text-time">{{ $review?->created_at?->diffForHumans() }}
                                                    </div>
                                                    <div>
                                                        @for ($i = 0; $i < 5; $i++)
                                                            <i
                                                                class="text-warning {{ $i < $review?->rating ? 'fas fa-star' : 'far fa-star' }}"></i>
                                                        @endfor
                                                    </div>
                                                    <div class="media-description text-muted">
                                                        {!! $review->review !!}
                                                    </div>
                                                    <div class="media-links">
                                                        <a
                                                            href="{{ route('single.product', $review?->product->slug) }}">{{ __('View') }}</a>
                                                        <div class="bullet"></div>
                                                        <a href="{{ route('admin.product-review.destroy', $review->id) }}"
                                                            data-modal="#deleteModal"
                                                            class="text-danger">{{ __('Trash') }}<< /a>
                                                    </div>
                                                </div>
                                            </li>
                                        @empty
                                            <div class="d-flex align-items-center flex-column">
                                                <x-empty-table :name="__('Reviews')" route="admin.product-review.index"
                                                    create="no" :message="__('No data found!')" colspan="7"></x-empty-table>
                                            </div>
                                        @endforelse
                                    </ul>
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
