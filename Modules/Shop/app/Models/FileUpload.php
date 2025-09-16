<?php

namespace Modules\Shop\app\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FileUpload extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'extension',
        'size',
        'path',
        'expiry_at',
    ];
    protected $casts = [
        'expiry_at' => 'datetime',
    ];
    public function scopeExpired($query) {
        $query->where('expiry_at', '<', Carbon::now());
    }

    public function scopeNotExpired($query) {
        $query->where('expiry_at', '>', Carbon::now());
    }

}
