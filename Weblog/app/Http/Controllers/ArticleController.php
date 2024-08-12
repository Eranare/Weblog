<?php

// app/Http/Controllers/ArticleController.php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
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
        $article = Article::findOrFail($id);
    
        // Check if the article is premium
        if ($article->is_premium) {
            // Check if the user is authenticated
            if (Auth::check()) {
                // Check if the user has a premium subscription
                if (Auth::user()->is_premium) {
                    $htmlContent = Storage::disk('articles')->get($article->content_file_path);
                    return view('articles.show', compact('article', 'htmlContent'));
                } else {
                    // Redirect to a page that suggests upgrading to a premium subscription
                    return redirect()->route('premium.info');
                }
            } else {
                // If not logged in, redirect to the login page
                return redirect()->route('login');
            }
        } else {
            // If the article is not premium, display it to everyone
            $htmlContent = Storage::disk('articles')->get($article->content_file_path);
            return view('articles.show', compact('article', 'htmlContent'));
        }
    }
}