<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Video extends Model
{
    use HasFactory;

    const ACTIVE = 1;
    const DEACTIVE = 0;

    protected $casts = [
        'tags' => 'array'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class)->count();
    }

    public function dislikes()
    {
        return $this->hasMany(Dislike::class)->count();
    }

    public function subscribes()
    {
        return $this->hasMany(Subscribe::class)->count();
    }

    public function isLikedByUser()
    {
        return $this->likes()->where('user_id',Auth::id())->first();
    }

    public function isDislikedByUser()
    {
        return $this->dislikes()->where('user_id',Auth::id())->first();
    }

    public function isSubscribedByUser()
    {
        return $this->subscribes()->where('user_id',Auth::id())->first();
    }

}
