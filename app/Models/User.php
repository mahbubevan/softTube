<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function email_logs()
    {
        return $this->hasMany(EmailLog::class, 'user_id');
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likedVideos()
    {
        return $this->belongsToMany(Video::class, 'likes');
    }

    public function dislikedVideos()
    {
        return $this->belongsToMany(Video::class, 'dislikes');
    }

    public function subscribedTo()
    {
        return $this->belongsToMany(User::class, 'subscribes', 'subscribe_by', 'subscribe_to');
    }

    public function subscribedBy()
    {
        return $this->belongsToMany(User::class, 'subscribes', 'subscribe_to', 'subscribe_by');
    }

    public function isSubscribedBy()
    {
        return $this->subscribedBy()->where('subscribe_by', Auth::id())->exists();
    }
}
