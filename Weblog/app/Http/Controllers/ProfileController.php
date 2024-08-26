<?php

// app/Http/Controllers/ProfileController.php
namespace App\Http\Controllers;

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
            // Add other validation rules as needed
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->is_writer = $request->has('is_writer');
        $user->save();

        return redirect()->route('profile.show')->with('status', 'Profile updated successfully!');
    }
}
