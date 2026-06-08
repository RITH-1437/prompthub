<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prompt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'prompt_content',
        'is_featured',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function isFavorited()
    {
        return $this->favorites()
            ->where('user_id', auth()->id())
            ->exists();
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function collections()
    {
        return $this->belongsToMany(Collection::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function averageRating()
    {
        return round(
            $this->ratings()->avg('rating'),
            1
        );
    }

    public function updateFeaturedStatus()
    {
        $averageRating = $this->ratings()->avg('rating');

        $favorites = $this->favorites()->count();

        if (
            $averageRating >= 4.5 &&
            $favorites >= 5
        ) {
            $this->update([
                'is_featured' => true,
            ]);
        }
    }
}
