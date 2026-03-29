<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    protected $fillable = ['name', 'slug'];

    public function movies()
    {
        return $this->hasMany(Movie::class);
    }
}
