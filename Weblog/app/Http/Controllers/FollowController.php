<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function follow(User $author)
    {
        if (!Auth::user()->isFollowing($author->id)) {
            Follow::create([
                'user_id' => Auth::id(),
                'followed_id' => $author->id,
            ]);

            return redirect()->back()->with('success', 'You are now following ' . $author->name);
        }

        return redirect()->back()->with('info', 'You are already following ' . $author->name);
    }

    public function unfollow(User $author)
    {
        $follow = Auth::user()->follows()->where('followed_id', $author->id)->first();

        if ($follow) {
            $follow->delete();

            return redirect()->back()->with('success', 'You have unfollowed ' . $author->name);
        }

        return redirect()->back()->with('info', 'You are not following ' . $author->name);
    }

    public function index()
    {
        $followedAuthors = Auth::user()->follows()->with('followedUser')->get();
    
        return view('follows.index', compact('followedAuthors'));
    }
}