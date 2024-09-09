<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CommentController extends Controller
{
    /**
     * Display a listing of the comments for an article.
     */
    public function index(Request $request, $articleId)
    {
        $article = Article::findOrFail($articleId);
        
        // Fetch top-level comments with their nested replies and user data
        $comments = $article->comments()
            ->whereNull('parent_id')
            ->with(['replies.user', 'user'])  // Eager load the user relationship
            ->get();

        return response()->json($comments);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'article_id' => 'required|exists:articles,id',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'article_id' => $request->article_id,
            'content' => $request->content,
            'parent_id' => $request->input('parent_id'), // For replies
        ]);

        return redirect()->back()->with('success', 'Comment posted!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
