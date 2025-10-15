<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AboutFeature extends Model
{
    protected $fillable = [
        'icon',
        'order',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    public function getTitleAttribute(): ?string
    {
        return $this?->translation?->title;
    }

    public function getDescriptionAttribute(): ?string
    {
        return $this?->translation?->description;
    }

    public function translation(): ?HasOne
    {
        return $this->hasOne(AboutFeatureTranslation::class)->where('lang_code', getSessionLanguage());
    }

    public function getTranslation($code): ?AboutFeatureTranslation
    {
        return $this->hasOne(AboutFeatureTranslation::class)->where('lang_code', $code)->first();
    }

    public function translations(): HasMany
    {
        return $this->hasMany(AboutFeatureTranslation::class);
    }
}
