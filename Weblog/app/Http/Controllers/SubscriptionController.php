<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function subscribe(User $writer)
    {
        if (Auth::user()->isSubscribedTo($writer)) {
            return redirect()->back()->with('error', 'You are already subscribed to this writer.');
        }

        Auth::user()->subscriptions()->create([
            'writer_id' => $writer->id,
        ]);

        return redirect()->back()->with('success', 'You have subscribed to ' . $writer->name);
    }

    public function unsubscribe(User $writer)
    {
        Auth::user()->subscriptions()->where('writer_id', $writer->id)->delete();

        return redirect()->back()->with('success', 'You have unsubscribed from ' . $writer->name);
    }
}
