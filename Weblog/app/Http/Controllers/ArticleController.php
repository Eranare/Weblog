<?php

// app/Http/Controllers/ArticleController.php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{


    public function index()
    {
        $articles = Article::all();
        return view('articles.index', compact('articles'));
    }



    public function show($id)
    {
        $article = Article::with('user')->findOrFail($id);
        $author = $article->user;  // Extract the author from the article
        $isSubscribed = Auth::check() && Auth::user()->isSubscribedTo($author->id);
    
        $htmlContent = Storage::disk('articles')->get($article->content_file_path);
    
        if ($article->is_premium && !$isSubscribed) {
            // Allow only the first 150 words and prompt for subscription
            return view('articles.show', compact('article', 'htmlContent', 'author', 'isSubscribed'));
        } else {
            // Show full content and comments if the article is not premium or the user is subscribed
            return view('articles.show', compact('article', 'htmlContent', 'author', 'isSubscribed'));
        }
    }
}
