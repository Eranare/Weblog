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

    if ($article->is_premium) {
        if (Auth::check() && Auth::user()->is_premium) {
            $htmlContent = Storage::disk('articles')->get($article->content_file_path);
            return view('articles.show', compact('article', 'htmlContent', 'author'));
        } else {
            return Auth::check() ? redirect()->route('home') : redirect()->route('login');
        }
    } else {
        $htmlContent = Storage::disk('articles')->get($article->content_file_path);
        return view('articles.show', compact('article', 'htmlContent', 'author'));
    }
}
}
