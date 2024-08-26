<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = ['user_id', 'writer_id'];

    // The subscriber
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // The writer being subscribed to
    public function writer()
    {
        return $this->belongsTo(User::class, 'writer_id');
    }
}
