<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class WriterController extends Controller
{
    public function index()
    {
        // Get the authenticated user (the writer)
        $writer = Auth::user();

        // Fetch the number of followers (assuming a 'follows' relationship exists)
        $followersCount = $writer->followers()->count();

        // Fetch the number of subscribers (assuming a 'subscriptions' relationship exists)
        $subscribersCount = $writer->subscribers()->where('active', true)->count();

        // Pass the data to the view
        return view('writer.dashboard', compact('followersCount', 'subscribersCount'));
    }
}
