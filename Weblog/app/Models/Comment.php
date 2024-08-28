<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'article_id',
        'parent_id',
        'content',
    ];

    // A comment belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A comment belongs to an article
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    // A comment can have many replies (nested comments)
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->with('replies');
    }

    // A comment can belong to a parent comment (if it's a reply)
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }
}
