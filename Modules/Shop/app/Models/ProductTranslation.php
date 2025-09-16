<?php

namespace Modules\Shop\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Shop\Database\factories\ProductTranslationFactory;

class ProductTranslation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'product_id',
        'lang_code',
        'title',
        'short_description',
        'additional_description',
        'description',
        'seo_title',
        'seo_description',
    ];

    public function product(): ?BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
