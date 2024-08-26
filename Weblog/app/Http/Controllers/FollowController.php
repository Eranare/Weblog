<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function follow(User $writer)
    {
        if (Auth::user()->isFollowing($writer)) {
            return redirect()->back()->with('error', 'You are already following this writer.');
        }

        Auth::user()->follows()->attach($writer->id);

        return redirect()->back()->with('success', 'You are now following ' . $writer->name);
    }

    public function unfollow(User $writer)
    {
        Auth::user()->follows()->detach($writer->id);

        return redirect()->back()->with('success', 'You have unfollowed ' . $writer->name);
    }
}
