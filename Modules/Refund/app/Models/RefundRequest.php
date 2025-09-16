<?php

namespace Modules\Refund\app\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Order\app\Models\Order;

class RefundRequest extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['user_id','order_id','reason','method','account_information','admin_response','status'];

    public function user() {
        return $this->belongsTo(User::class)->select('id', 'name', 'email', 'image');
    }

    public function order() {
        return $this->belongsTo(Order::class,'order_id','order_id')->select('id', 'order_id');
    }
}
