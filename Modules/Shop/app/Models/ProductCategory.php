<?php

namespace Modules\Shop\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'status'];

    // make a accessor for translation
    public function getTitleAttribute(): ?string
    {
        return $this?->translation?->title;
    }

    public function translation(): ?HasOne
    {
        return $this->hasOne(ProductCategoryTranslation::class)->where('lang_code', getSessionLanguage());
    }

    public function getTranslation($code): ?ProductCategoryTranslation
    {
        return $this->hasOne(ProductCategoryTranslation::class)->where('lang_code', $code)->first();
    }

    public function translations(): ?HasMany
    {
        return $this->hasMany(ProductCategoryTranslation::class, 'product_category_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'product_category_id');
    }
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 0);
    }
}
