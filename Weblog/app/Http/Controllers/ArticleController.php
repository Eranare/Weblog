<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        // Fetch all articles ordered by creation date (newest to oldest), excluding hidden articles, with pagination
        $paginatedArticles = Article::where('is_flagged_for_deletion', false)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Return the view with paginated articles
        return view('home', compact('paginatedArticles'));
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
