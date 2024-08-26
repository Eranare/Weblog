<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Define the many-to-many relationship with Article
    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_category');
    }
    public function users() //This user created the category
    {
        return $this->belongsTo(User::class, 'users');
    }
}
