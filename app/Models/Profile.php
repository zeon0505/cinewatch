<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['user_id', 'name', 'avatar', 'is_kids', 'last_active_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
