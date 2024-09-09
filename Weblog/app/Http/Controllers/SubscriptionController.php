<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    // List subscribed authors
    public function index()
    {
        // Get subscriptions where the subscription is still valid (active or end_date in the future)
        $subscribedAuthors = Auth::user()->subscriptions()
            ->with('author')  // Eager load author data
            ->where(function ($query) {
                $query->where('active', true)
                      ->orWhere('end_date', '>', now());
            })
            ->get();
    
        return view('subscriptions.index', compact('subscribedAuthors'));
    }
    // Show payment page
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

        // Show the payment page, passing the redirect URL to return the user later
        return view('subscriptions.payment', compact('author'));
    }

        // Handle subscription
        public function subscribe(Request $request, User $author)
        {
            // Ensure user is logged in
            if (!Auth::check()) {
                return redirect()->route('login');
            }
    
            // Check if the user is already subscribed
            if (Auth::user()->isSubscribedTo($author->id)) {
                return redirect()->back()->with('info', 'You are already subscribed to this author.');
            }
    
            // Determine subscription plan and set subscription duration
            $plan = $request->input('plan');
            if ($plan === 'monthly') {
                $endDate = Carbon::now()->addMonth();
            } else if ($plan === 'yearly') {
                $endDate = Carbon::now()->addYear();
            } else {
                return redirect()->back()->withErrors('Invalid subscription plan selected.');
            }
    
            // Create the subscription
            Auth::user()->subscriptions()->create([
                'author_id' => $author->id,
                'start_date' => now(),
                'end_date' => $endDate,
                'is_active' => true,
            ]);
    
            // Retrieve the redirect URL from the request
            $redirectUrl = $request->input('redirect_url') ?? route('home'); // Default to home if no redirect URL
    
            // Redirect the user back to the correct page
            return redirect($redirectUrl)->with('success', 'You have successfully subscribed to ' . $author->name);
        }
    // Unsubscribe but keep access until the end date
    public function unsubscribe($authorId)
    {
        // Find the active subscription to the author
        $subscription = Subscription::where('user_id', Auth::id())
            ->where('author_id', $authorId)
            ->where('active', true)
            ->firstOrFail();

        // Set subscription to inactive, but don't delete
        $subscription->update(['active' => false]);

        return redirect()->back()->with('success', 'You have successfully unsubscribed. You will retain access until your subscription expires.');
    }
}
