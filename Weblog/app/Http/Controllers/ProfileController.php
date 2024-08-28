<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
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
        $user->is_writer = $request->has('is_writer');
        $user->save();

        return redirect()->route('profile.show')->with('status', 'Profile updated successfully!');
    }

    // New method to show the author's profile
    public function showAuthorProfile(User $author)
    {
        // Retrieve all articles written by this author
        $articles = Article::where('user_id', $author->id)->get();

        return view('authors.show', compact('author', 'articles'));
    }
}
