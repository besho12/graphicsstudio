<?php

namespace Modules\Shop\app\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Location\app\Models\Country;

class DeliveryAddress extends Model {
    use HasFactory;

    protected $fillable = [
        'user_id', 'country_id', 'title', 'first_name', 'last_name', 'email', 'phone', 'province', 'city', 'address', 'zip_code',
    ];

    public function country(): ?BelongsTo {
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function user(): ?BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }
}
