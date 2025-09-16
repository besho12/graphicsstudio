<?php

namespace Modules\Shop\app\Models;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Modules\Order\app\Models\OrderProduct;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model {
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'product_category_id',
        'slug',
        'type',
        'file_path',
        'image',
        'views',
        'is_popular',
        'is_new',
        'tags',
        'sku',
        'qty',
        'price',
        'sale_price',
        'status',
    ];

    public const PHYSICAL_TYPE = 'physical';
    public const DIGITAL_TYPE = 'digital';

    public static function getTypes(): array {
        return [
            self::PHYSICAL_TYPE => __('Physical Product'),
            self::DIGITAL_TYPE  => __('Digital Product'),
        ];
    }

    public function getFavoritedByClientAttribute() {
        if (auth()->guard('web')->check()) {
            return $this->relationLoaded('favoritedBy') ? in_array(userAuth()->id, $this->favoritedBy->pluck('id')->toArray()) : false;
        }

        return false;
    }

    public function favoritedBy() {
        return $this->belongsToMany(User::class, 'favorite_product_user')->withTimestamps();
    }

    public function getTitleAttribute(): ?string {
        return $this?->translation?->title;
    }

    public function getShortDescriptionAttribute(): ?string {
        return $this?->translation?->short_description;
    }
    public function getDescriptionAttribute(): ?string {
        return $this?->translation?->description;
    }
    public function getAdditionalDescriptionAttribute(): ?string {
        return $this?->translation?->additional_description;
    }

    public function getSeoTitleAttribute(): ?string {
        return $this?->translation?->seo_title;
    }

    public function getSeoDescriptionAttribute(): ?string {
        return $this?->translation?->seo_description;
    }

    public function category(): ?BelongsTo {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }
    public function admin(): ?BelongsTo {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function translation(): ?HasOne {
        return $this->hasOne(ProductTranslation::class)->where('lang_code', getSessionLanguage());
    }

    public function getTranslation($code): ?ProductTranslation {
        return $this->hasOne(ProductTranslation::class)->where('lang_code', $code)->first();
    }

    public function translations(): ?HasMany {
        return $this->hasMany(ProductTranslation::class, 'product_id');
    }
    public function images(): ?HasMany {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
    public function reviews(): ?HasMany {
        return $this->hasMany(ProductReview::class);
    }

    public function scopeActive($query) {
        return $query->where('status', 1);
    }

    public function scopeInactive($query) {
        return $query->where('status', 0);
    }

    public function scopePopular($query) {
        return $query->where('is_popular', 1);
    }
    public function order_products(): ?HasMany {
        return $this->hasMany(OrderProduct::class);
    }
    public function download() {
        $setting = cache()->get('setting');
        $siteName = Str::slug($setting->app_name);

        $filename = Str::slug($this->slug) . '-' . time() . '.' . File::extension($this->file_path);
        $path = storage_path("app/{$this->file_path}");

        if (!File::exists($path)) {
            abort(404, 'File not found.');
        }
        return response()->download($path, $filename);
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function ($product) {
            try {
                $product->favoritedBy()->detach();
                $product->reviews()->delete();
                // Handle product translations
                if ($product->translations) {
                    $product->translations->each(function ($translation) {
                        $translation->product()->dissociate();
                        $translation->delete();
                    });
                }

                // Handle product images
                if ($product->images) {
                    $product->images->each(function ($image) {
                        if ($image->image && !str_contains($image->image, 'website/images')) {
                            if (File::exists(public_path($image->image))) {
                                File::delete(public_path($image->image));
                            }
                        }
                        if ($image->preview && !str_contains($image->preview, 'website/images')) {
                            if (File::exists(public_path($image->preview))) {
                                File::delete(public_path($image->preview));
                            }
                        }
                        $image->product()->dissociate();
                        $image->delete();
                    });
                }
                if ($product->file_path) {
                    $path = "app/{$product->file_path}";
                    if (File::exists(storage_path($path))) {
                        File::delete(storage_path($path));
                    }
                }

                // Handle main product image
                if ($product->image && !str_contains($product->image, 'website/images')) {
                    if (File::exists(public_path($product->image))) {
                        File::delete(public_path($product->image));
                    }
                }
                // Handle main product image
                if ($product->additional_image && !str_contains($product->additional_image, 'website/images')) {
                    if (File::exists(public_path($product->additional_image))) {
                        File::delete(public_path($product->additional_image));
                    }
                }
            } catch (\Exception $e) {
                $notification = __('Unable to delete as relational data exists!');
                $notification = ['message' => $notification, 'alert-type' => 'error'];
                return redirect()->back()->with($notification);
            }
        });
    }
}
