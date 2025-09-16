<?php

namespace Modules\Order\app\Models;

use App\Enums\OrderStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Refund\app\Models\RefundRequest;

class Order extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['order_status'];

    public function user() {
        return $this->belongsTo(User::class)->select('id', 'name', 'email', 'image');
    }
    public function order_address(): HasOne {
        return $this->hasOne(OrderAddress::class, 'order_id');
    }
    public function refund(): HasOne {
        return $this->hasOne(RefundRequest::class, 'order_id','order_id');
    }
    public function order_products(): HasMany {
        return $this->hasMany(OrderProduct::class, 'order_id');
    }

    public function scopeDraft($query) {
        return $query->where('order_status', OrderStatus::DRAFT);
    }
    public function scopePaymentSuccess($query) {
        return $query->where('payment_status', 'success');
    }
    public function scopePaymentPending($query) {
        return $query->where('payment_status', 'pending');
    }
}
