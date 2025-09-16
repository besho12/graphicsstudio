<?php

namespace Modules\Order\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShippingMethod extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['fee','is_free','minimum_order','is_default','status'];
    public function getTitleAttribute(): ?string
    {
        return $this?->translation?->title;
    }

    public function translation(): ?HasOne
    {
        return $this->hasOne(ShippingMethodTranslation::class)->where('lang_code', getSessionLanguage());
    }

    public function getTranslation($code): ?ShippingMethodTranslation
    {
        return $this->hasOne(ShippingMethodTranslation::class)->where('lang_code', $code)->first();
    }

    public function translations(): ?HasMany
    {
        return $this->hasMany(ShippingMethodTranslation::class, 'shipping_method_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    public function scopeFree($query)
    {
        return $query->where('is_free', 1);
    }
    public function scopeNotFree($query)
    {
        return $query->where('is_free', 0);
    }
    public function scopeDefault($query)
    {
        return $query->where('is_default', 1);
    }
    
    
}
