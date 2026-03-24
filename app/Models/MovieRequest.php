<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovieRequest extends Model
{
    protected $table = 'request_films'; // Keep current table name to avoid migration issues

    protected $fillable = [
        'user_id',
        'title',
        'year',
        'description',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
