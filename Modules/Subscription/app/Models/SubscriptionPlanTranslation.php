<?php

namespace Modules\Subscription\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubscriptionPlanTranslation extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'subscription_plan_id',
        'lang_code',
        'plan_name',
        'short_description',
        'description',
        'button_text',
    ];

    public function subscription_plan(): ?BelongsTo {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }

}
