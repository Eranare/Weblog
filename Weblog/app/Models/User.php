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

    // Relationship for the writers a user is subscribed to
    public function subscriptions(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'subscriptions', 'user_id', 'writer_id')
            ->withTimestamps();
    }

    // Relationship for the subscribers a writer has
    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'subscriptions', 'writer_id', 'user_id')
            ->withTimestamps();
    }

    // Check if a user is subscribed to a specific writer
    public function isSubscribedTo(User $writer): bool
    {
        return $this->subscriptions()->where('writer_id', $writer->id)->exists();
    }

    // Relationship for the writers a user follows
    public function follows(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'writer_id')
            ->withTimestamps();
    }

    // Relationship for the followers a writer has
    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follows', 'writer_id', 'user_id')
            ->withTimestamps();
    }

    // Check if a user is following a specific writer
    public function isFollowing(User $writer): bool
    {
        return $this->follows()->where('writer_id', $writer->id)->exists();
    }
}
