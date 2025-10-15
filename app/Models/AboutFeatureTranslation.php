<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AboutFeatureTranslation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'about_feature_id',
        'lang_code',
        'title',
        'description',
    ];

    public function aboutFeature(): BelongsTo
    {
        return $this->belongsTo(AboutFeature::class);
    }
}