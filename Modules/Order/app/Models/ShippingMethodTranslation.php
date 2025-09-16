<?php

namespace Modules\Order\app\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Order\app\Models\ShippingMethod;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShippingMethodTranslation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['shipping_method_id','lang_code','title'];

    public function shipping_method(): ?BelongsTo
    {
        return $this->belongsTo(ShippingMethod::class);
    }
}
