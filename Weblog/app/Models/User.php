<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_writer',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }
    //DONT MOVE THESE TO PROFILE
    // Relationship for the articles a user has written
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    // Users can follow many writers
    public function follows()
    {
        return $this->hasMany(Follow::class, 'user_id');
    }

    // Writers can be followed by many users
    public function followers()
    {
        return $this->hasMany(Follow::class, 'followed_id');
    }

    // Check if the user is following a writer
    public function isFollowing($authorId)
    {
        return $this->follows()->where('followed_id', $authorId)->exists();
    }

    //ToDo: Add Subscriptions here later
}
