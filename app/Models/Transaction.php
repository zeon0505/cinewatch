<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'external_id',
        'amount',
        'status',
        'snap_token',
        'payment_info'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
