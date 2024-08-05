<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $articles = Article::all();
        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   //Should we validate userid as well?
        //Add validate for is_premium checkbox.
        $request->validate([
            'title' => 'required',
            'content' => 'required', //
        ]);

        //generate filename for stored html
        $filename = Str::slug($request->title) . date('m-d-Y_hia') . '.html'; //maybe add date or something to make name less likely to collide.
        Storage::disk('articles')->put($filename, $request->content);

        //create and save article
        $article = new Article();
        $article->title = $request->title;
        $article->content_file_path = $filename;
        $article->user_id = '1';
        $article->is_premium = false;
        $article->save();

        return redirect()->route('articles.create')->with('succes', 'Article created succesfully');
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
