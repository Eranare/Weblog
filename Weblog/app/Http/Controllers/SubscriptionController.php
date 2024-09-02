<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{

    public function index()
    {
        $subscribedAuthors = Auth::user()->subscriptions()->with('subscribedAuthor')->get();

        return view('subscriptions.index', compact('subscribedAuthors'));
    }

    public function showPaymentPage(User $author)
    {
        // Ensure user is logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Check if the user is already subscribed
        if (Auth::user()->isSubscribedTo($author->id)) {
            return redirect()->route('articles.show', $author->id)->with('info', 'You are already subscribed to this author.');
        }

        // Show the payment page
        return view('subscriptions.payment', compact('author'));
    }

    public function subscribe(Request $request, User $author)
    {
        // Ensure user is logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        //Stripe or something here


        Auth::user()->subscriptions()->create([
            'author_id' => $author->id,
        ]);

        $latestArticle = $author->articles()->latest()->first();

        if ($latestArticle) {
            return redirect()->route('articles.show', $latestArticle->id)->with('success', 'You have successfully subscribed to ' . $author->name);
        } else {

            return redirect()->route('home')->with('success', 'You have successfully subscribed to ' . $author->name);
        }
    }
}
