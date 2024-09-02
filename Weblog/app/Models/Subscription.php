<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'author_id',
    ];

    public function subscribedAuthor()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function subscriber()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
