<?php

namespace Modules\Shop\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Shop\Database\factories\ProductImageFactory;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
    ];

    public function getImageUrlAttribute(): ?string
    {
        if ($this->image) {
            return asset($this->image);
        }

        return $this->image;
    }

    public function getPreviewUrlAttribute(): ?string
    {
        if ($this->preview) {
            return asset($this->preview);
        }

        return $this->preview;
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
