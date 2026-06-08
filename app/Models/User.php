<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'avatar',
        'bio',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    public function prompts()
    {
        return $this->hasMany(Prompt::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoritedPrompts()
    {
        return $this->belongsToMany(Prompt::class, 'favorites')->withTimestamps();
    }

    public function following()
    {
        return $this->belongsToMany(
            User::class,
            'follows',
            'follower_id',
            'following_id'
        );
    }

    public function followers()
    {
        return $this->belongsToMany(
            User::class,
            'follows',
            'following_id',
            'follower_id'
        );
    }

    public function collections()
    {
        return $this->hasMany(Collection::class);
    }

    public function achievements()
    {
        return $this->hasMany(Achievement::class);
    }

    public function totalFavorites()
    {
        return Favorite::whereIn(
            'prompt_id',
            $this->prompts()->pluck('id')
        )->count();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
