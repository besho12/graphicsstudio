<?php

namespace Modules\Order\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Shop\app\Models\Product;

class OrderProduct extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function product() {
        return $this->belongsTo(Product::class);
    }
}
