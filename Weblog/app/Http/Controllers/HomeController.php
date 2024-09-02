<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class HomeController extends Controller
{
    public function index()
    {
        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        if (Auth::check()) {
            $user = Auth::user();

            // Fetch articles from subscribed authors (without limiting)
            $subscribedAuthorIds = $user->subscriptions()->pluck('author_id');
            $subscribedArticles = Article::whereIn('user_id', $subscribedAuthorIds)
                                         ->orderBy('created_at', 'desc')
                                         ->with('user')
                                         ->get();

            // Fetch articles from followed authors that are not subscribed
            $followedAuthorIds = $user->follows()
                                      ->whereNotIn('followed_id', $subscribedAuthorIds)
                                      ->pluck('followed_id');
            $followedArticles = Article::whereIn('user_id', $followedAuthorIds)
                                       ->orderBy('created_at', 'desc')
                                       ->with('user')
                                       ->get();

            // Fetch articles from other authors, excluding those already included
            $excludedAuthorIds = $subscribedAuthorIds->merge($followedAuthorIds);
            $generalArticles = Article::whereNotIn('user_id', $excludedAuthorIds)
                                       ->orderBy('created_at', 'desc')
                                       ->with('user')
                                       ->get();

            // Combine all articles and sort by date
            $articles = $subscribedArticles->concat($followedArticles)->concat($generalArticles)->sortByDesc('created_at');

            // Manual pagination
            $paginatedArticles = new LengthAwarePaginator(
                $articles->forPage($currentPage, $perPage),
                $articles->count(),
                $perPage,
                $currentPage,
                ['path' => request()->url(), 'query' => request()->query()]
            );

        } else {
            // If the user is not logged in, display the newest articles with pagination
            $paginatedArticles = Article::orderBy('created_at', 'desc')
                                         ->with('user')
                                         ->paginate($perPage);
        }

        return view('home', compact('paginatedArticles'));
    }
}
