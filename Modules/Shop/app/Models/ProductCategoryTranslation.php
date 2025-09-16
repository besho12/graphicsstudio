<?php

namespace Modules\Shop\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductCategoryTranslation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'product_category_id',
        'lang_code',
        'title',
    ];

    public function category(): ?BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }
}
