<?php

namespace App\Http\Controllers\Frontend;

use Exception;
use Illuminate\View\View;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Order\app\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Shop\app\Models\Product;
use Modules\Shop\app\Models\ProductReview;
use Modules\Shop\app\Models\ProductCategory;
use Modules\GlobalSetting\app\Models\CustomPagination;

class ShopController extends Controller {
    public function fetchProducts(Request $request) {
        $categories = ProductCategory::with(['translation' => function ($query) {
            $query->select('product_category_id', 'title');
        }])->withCount(['products' => function ($query) {
            $query->active();
        }])->whereHas('products', function ($query) {
            $query->active();
        })->active()->latest()->get(['id', 'slug']);

        $query = Product::select('id', 'slug', 'image', 'price','qty', 'sale_price', 'is_new')->with(['favoritedBy', 'translation' => function ($query) {
            $query->select('product_id', 'title');
        }])->withCount(['reviews as average_rating' => function ($query) {
            $query->select(DB::raw('coalesce(avg(rating), 0) as average_rating'))->where('status', 1);
        }])->whereHas('category', function ($query) {
            $query->active();
        })->active();

        $query->when($request->filled('search'), function ($qa) use ($request) {
            $qa->whereHas('translation', function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')->orWhere('short_description', 'like', '%' . $request->search . '%')->orWhere('description', 'like', '%' . $request->search . '%');
            })->orWhere('price', 'like', '%' . $request->search . '%')->orWhere('sale_price', 'like', '%' . $request->search . '%');
        });

        //orderby filter
        switch ($request?->orderby) {
        case 'oldest':
            $query->orderBy('id');
            break;
        case 'popularity':
            $query->orderByDesc('is_popular')->latest();
            break;
        case 'rating':
            $query->orderByDesc('average_rating');
            break;
        case 'price':
            $query->orderBy('price');
            break;
        case 'price-desc':
            $query->orderByDesc('price');
            break;
        default:
            $query->orderByDesc('id');
            break;
        }

        // Filter by tag
        $query->when($request->filled('tag'), function ($query) use ($request) {
            $query->whereJsonContains('tags', [['value' => $request->tag]]);
        });

        if ($request->filled('category')) {
            $categoriesSlugs = explode(',', $request->category);
            $query->whereHas('category', function ($q) use ($categoriesSlugs) {
                $q->whereIn('slug', $categoriesSlugs);
            });
        }

        // Price range filter
        $max_price = Product::max('price') ?: 1000;
        
        $isDefaultCurrency = allCurrencies()->where(['is_default'=> 'yes','currency_code'=>session('currency_code', 'en')])->first();

        if ($isDefaultCurrency) {
            $from = $request->filled('from') ? (float) preg_replace('/[^\d.]/', '', $request->from) : 0;
            $to = $request->filled('to') ? (float) preg_replace('/[^\d.]/', '', $request->to) : $max_price;
        } else {
            $from = $request->filled('from') ? reverseCurrency((float) preg_replace('/[^\d.]/', '', $request->from)) : 0;
            $to = $request->filled('to') ? reverseCurrency((float) preg_replace('/[^\d.]/', '', $request->to)) : $max_price;
        }
        
        $query->whereBetween('price', [$from, $to]);

        // Rating filter
        $query->when($request->filled('rating'), function ($qa) use ($request) {
            $ratingsArray = explode(',', $request->rating);
            $qa->having('average_rating', '>=', min((array) $ratingsArray));
        });

        $product_per_age = cache('CustomPagination')?->product_list ?? CustomPagination::where('section_name', 'Product List')->value('item_qty');
        $products = $query->paginate($product_per_age)->withQueryString();

        // Prepare the response data
        $topTags = $this->topTags();
        $lastPage = $products->lastPage();
        $page = $request->page ?? 1;
        $itemCount = $products->count();
        $breadcrumb_result = __('Showing') . " {$page} – {$lastPage} " . __('of') . " {$itemCount} " . __('results');

        return response()->json([
            'views'     => view('frontend.pages.shop.partials.products-card', compact('products', 'categories', 'topTags', 'breadcrumb_result'))->render(),
            'max_price' => currency($max_price, false, false),
            'from'      => currency($from, false, false),
            'to'        => currency($to, false, false),
        ]);
    }
    public function singleProduct($slug): View {
        $product = Product::select('id', 'product_category_id', 'slug','type', 'sku', 'price','qty','sale_price', 'is_new', 'tags', 'image')->with(['favoritedBy',
            'translation'          => function ($query) {
                $query->select('product_id', 'title', 'short_description', 'description', 'additional_description', 'seo_title', 'seo_description');
            }, 'reviews' => function ($query) {
                $query->active()->select('product_id', 'user_id', 'name', 'review', 'rating', 'created_at');
            }, 'reviews.user' => function ($query) {
                $query->active()->select('id', 'image');
            }, 'category' => function ($query) {
                $query->active()->select('id','slug');
            },
            'category.translation' => function ($query) {
                $query->select('product_category_id', 'title');
            }, 'images'  => function ($query) {
                $query->select('product_id', 'image');
            },
        ])->whereHas('category', function ($query) {
            $query->active();
        })->withCount(['reviews' => function ($query) {
            $query->active();
        }, 'reviews as average_rating' => function ($query) {
            $query->select(DB::raw('coalesce(avg(rating), 0) as average_rating'))->where('status', 1);
        }])->where('slug', $slug)->active()->first();

        if (!$product) {
            abort(404);
        }

        if (Auth::guard('web')->check()) {
            $complete = Order::where('user_id', userAuth()->id)
                ->where('order_status', OrderStatus::COMPLETED->value)
                ->whereHas('order_products', function ($query) use ($product) {
                    $query->where('product_id', $product->id);
                })->exists();

            $alreadyReview = ProductReview::where(['user_id' => userAuth()->id, 'product_id' => $product->id])->exists();
            $canReview = $complete && !$alreadyReview;
        } else {
            $canReview = false;
        }

        $tagString = '';
        if ($product?->tags) {
            $tags = json_decode($product?->tags, true);
            $tagString = implode('', array_map(function ($tag) {
                return '<a href="' . route('shop', ['tag' => html_decode($tag['value'])]) . '">' . $tag['value'] . '</a>';
            }, $tags));
        }

        $relatedProducts = $this->relatedProduct($product?->category?->slug,$product?->slug);

        return view('frontend.pages.shop.single-product', compact('product', 'canReview','tagString','relatedProducts'));
    }
    private function topTags() {
        $tagsData = Product::select('tags')->whereHas('category', function ($query) {
            $query->active();
        })->active()->get();
        $flatTags = [];
        foreach ($tagsData as $tagsEntry) {
            $tags = json_decode($tagsEntry->tags, true);
            $flatTags = array_merge($flatTags, $tags ?? []);
        }
        $tagCounts = array_count_values(array_column($flatTags, 'value'));
        arsort($tagCounts);
        return array_slice($tagCounts, 0, count($tagCounts), true);
    }

    private function relatedProduct($category_slug,$product_slug) {
        $per_age = cache('CustomPagination')?->related_product_list ?? CustomPagination::where('section_name', 'Related Product List')->value('item_qty');

        return Product::select('id', 'slug', 'image', 'price','qty', 'sale_price', 'is_new')->with(['favoritedBy', 'translation' => function ($query) {
            $query->select('product_id', 'title');
        }])->withCount(['reviews as average_rating' => function ($query) {
            $query->select(DB::raw('coalesce(avg(rating), 0) as average_rating'))->where('status', 1);
        }])->whereHas('category', function ($query) use ($category_slug) {
            $query->whereSlug($category_slug)->active();
        })->whereNot('slug',$product_slug)->active()->get($per_age);
    }
}
