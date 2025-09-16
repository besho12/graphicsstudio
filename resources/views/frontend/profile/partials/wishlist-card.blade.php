@php
    $per_age =
        cache('CustomPagination')?->wishlist ??
        Modules\GlobalSetting\app\Models\CustomPagination::where('section_name', 'Wishlist')->value('item_qty');

    $userFavorites = userAuth()
        ->favoriteProducts()
        ->with('translation')
        ->withCount([
            'reviews as average_rating' => function ($query) {
                $query
                    ->select(Illuminate\Support\Facades\DB::raw('coalesce(avg(rating), 0) as average_rating'))
                    ->where('status', 1);
            },
            'reviews as reviews_count' => function ($query) {
                $query->where('status', 1);
            },
        ])
        ->withCount('order_products')
        ->active()
        ->paginate($per_age);
@endphp
<h4>{{ __('Wishlist') }}</h4>
<div class="wsus__dashboard_wishlist">
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr>
                            <th class="image text-center">
                                {{ __('Image') }}
                            </th>
                            <th class="details text-center">
                                {{ __('Details') }}
                            </th>
                            <th class="sale_tk text-center">
                                {{ __('Total Sale') }}
                            </th>
                            <th class="status text-center">
                                {{ __('View') }}
                            </th>
                            <th class="actions text-center">
                                {{ __('Action') }}
                            </th>
                        </tr>
                        @forelse ($userFavorites as $product)
                            <tr>
                                <td class="image">
                                    <a href="{{ route('single.product', $product?->slug) }}">
                                        <img src="{{ asset($product?->image) }}" alt="{{ $product?->title }}"
                                            class="img-fluid w-100">
                                    </a>
                                </td>
                                <td class="details">
                                    <h5>{{ $product?->title }}</h5>
                                    <p class="rating">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= floor($product?->average_rating))
                                                <i class="fas fa-solid fa-star"></i>
                                            @elseif ($i - 0.5 <= $product?->average_rating)
                                                <i class="fas fa-solid fa-star-half-alt"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                        <span>({{ $product?->reviews_count }}
                                            {{ __('Reviews') }})</span>
                                    </p>
                                    <h6>{{ currency($product?->price) }}</h6>
                                </td>
                                <td class="sale_tk text-center">
                                    <p>{{ $product?->order_products_count ?? 0 }}</p>
                                </td>
                                <td class="status text-center">
                                    <p>{{ $product?->views }}</p>
                                </td>
                                <td class="actions text-center">
                                    <ul class="d-flex">
                                        <li><a data-slug="{{ $product?->slug }}" class="wishlist-remove" href="javascript:;"><i class="far fa-trash-alt" aria-hidden="true"></i></a></a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <x-data-not-found />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@if ($userFavorites->hasPages())
    {{ $userFavorites->onEachSide(0)->links('frontend.pagination.custom') }}
@endif
