<?php
// app/Http/Controllers/ProfileController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.show', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        return redirect()->route('profile.show')->with('status', 'Profile updated successfully!');
    }

    // Show the Become a Writer page
    public function showBecomeWriterPage()
    {
        return view('profile.becomeWriter');
    }

    // Confirm that the user becomes a writer
    public function confirmBecomeWriter(Request $request)
    {
        $user = Auth::user();
        $user->is_writer = true;  // Set the user as a writer
        $user->save();

        return redirect()->route('profile.show')->with('status', 'You are now a writer!');
    }



    public function showAuthorProfile(User $author)
    {
        // Check if the authenticated user is subscribed to the author
        $isSubscribed = Auth::check() && Auth::user()->isSubscribedTo($author->id);
    
        // Use paginate() to get paginated articles by the author, excluding flagged ones
        $articles = $author->articles()->where('is_flagged_for_deletion', false)->paginate(10);
    
        // Pass $isSubscribed to the view
        return view('authors.show', compact('author', 'articles', 'isSubscribed'));
    }
    
}
