<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'avatar', 'status', 'is_vip', 'vip_until'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'vip_until' => 'datetime',
        ];
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

    public function profiles()
    {
        return $this->hasMany(Profile::class);
    }

    public function getIsVipAttribute($value)
    {
        if (!$value) return false;
        if (!$this->vip_until) return false;
        
        return now()->lt($this->vip_until);
    }
}
