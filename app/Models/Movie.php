<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title', 
        'slug', 
        'description', 
        'thumbnail', 
        'video_url', 
        'subtitle_url',
        'duration', 
        'age_rating',
        'audience_type',
        'rating_value',
        'category_id', // Keeping for now to avoid breaking existing code during migration
        'views',
        'tmdb_id',
        'year',
        'status',
        'is_premium',
        'series_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function watchlists()
    {
        return $this->hasMany(Watchlist::class);
    }

    public function histories()
    {
        return $this->hasMany(History::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function scopeKids($query)
    {
        return $query->where(function($q) {
            $q->where('audience_type', 'kids');
        });
    }

    public function series()
    {
        return $this->belongsTo(Series::class);
    }
}
