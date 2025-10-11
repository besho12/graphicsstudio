<?php

namespace Modules\Service\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Service\Database\factories\ServiceTranslationFactory;

class ServiceTranslation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'service_id',
        'lang_code',
        'title',
        'short_description',
        'description',
        'seo_title',
        'btn_text',
        'seo_description',
        'benefit_1_title',
        'benefit_1_description',
        'benefit_2_title',
        'benefit_2_description',
        'benefit_3_title',
        'benefit_3_description',
        'feature_1_title',
        'feature_1_description',
        'feature_1_highlight',
        'feature_2_title',
        'feature_2_description',
        'feature_2_highlight',
        'feature_3_title',
        'feature_3_description',
        'feature_3_highlight',
        'process_1_title',
        'process_1_description',
        'process_2_title',
        'process_2_description',
        'process_3_title',
        'process_3_description',
        'process_4_title',
        'process_4_description',
    ];

    public function service(): ?BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
