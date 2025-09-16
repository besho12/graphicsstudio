<?php

namespace Modules\Subscription\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Subscription\app\Enums\SubscriptionStatusType;

class SubscriptionPlan extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'plan_price',
        'expiration_date',
        'button_url',
        'serial',
        'status'
    ];

    public function getPlanNameAttribute(): ?string {
        return $this?->translation?->plan_name;
    }

    public function getShortDescriptionAttribute(): ?string {
        return $this?->translation?->short_description;
    }
    public function getDescriptionAttribute(): ?string {
        return $this?->translation?->description;
    }
    public function getButtonTextAttribute(): ?string {
        return $this?->translation?->button_text;
    }

    public function translation(): ?HasOne {
        return $this->hasOne(SubscriptionPlanTranslation::class)->where('lang_code', getSessionLanguage());
    }

    public function getTranslation($code): ?SubscriptionPlanTranslation {
        return $this->hasOne(SubscriptionPlanTranslation::class)->where('lang_code', $code)->first();
    }

    public function translations(): ?HasMany {
        return $this->hasMany(SubscriptionPlanTranslation::class, 'subscription_plan_id');
    }

    public function scopeActive($query) {
        return $query->where('status', SubscriptionStatusType::ACTIVE->value);
    }

    public function scopeInactive($query) {
        return $query->where('status', SubscriptionStatusType::INACTIVE->value);
    }
}
