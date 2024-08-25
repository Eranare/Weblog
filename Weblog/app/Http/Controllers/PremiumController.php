<?php

// app/Http/Controllers/PremiumController.php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class PremiumController extends Controller
{
    // Display all premium articles with previews for non-premium users and guests
    public function index()
    {
        $premiumArticles = Article::where('is_premium', true)->latest()->paginate(10);

        return view('premium.index', compact('premiumArticles'));
    }

    // Display a single premium article (with access control)
    public function show($id)
    {
        $article = Article::findOrFail($id);

        if ($article->is_premium && (!auth()->check() || !auth()->user()->is_premium)) {
            return redirect()->route('premium.subscribe')->with('warning', 'Please subscribe to access full premium content.');
        }

        return view('premium.show', compact('article'));
    }

    // Show the subscription page
    public function subscribe()
    {
        return view('premium.subscribe');
    }
    public function processSubscription(Request $request)
    {
        $user = auth()->user();
        $user->is_premium = true;
        $user->save();

        return redirect()->route('articles.premium')->with('status', 'You are now a premium subscriber!');
    }
}