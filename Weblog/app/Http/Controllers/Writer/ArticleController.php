<?php

namespace App\Http\Controllers\Writer;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'writer']);
    }
    public function index()
    {
        // Fetch articles that belong to the logged-in user
        $user = Auth::user();
        $articles = Article::where('user_id', $user->id)->get();

        return view('writer.articles.index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('writer.articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'categories' => 'array|exists:categories,id'
        ]);
    
        $filename = Str::slug($request->title) . date('m-d-Y_hia') . '.html';
    
        try {
            Storage::disk('articles')->put($filename, $request->content);
            \Log::info('Article content saved successfully', ['filename' => $filename]);
        } catch (\Exception $e) {
            \Log::error('Failed to save article content', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to save article content.');
        }
    
        $article = new Article();
        $article->title = $request->title;
        $article->content_file_path = $filename;
        $article->user_id = auth()->id();
        $article->is_premium = $request->has('is_premium');
        $article->save();
    
        // Attach categories to the article
        $article->categories()->attach($request->categories);
    
        return redirect()->route('writer.articles.create')->with('success', 'Article created successfully');
    }
    
    public function show($id)
    {
        $article = Article::findOrFail($id);
        $htmlContent = Storage::disk('articles')->get($article->content_file_path);
        return view('writer.articles.show', compact('article', 'htmlContent'));
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $categories = Category::all();
        $htmlContent = Storage::disk('articles')->get($article->content_file_path);
        return view('writer.articles.edit', compact('article', 'categories', 'htmlContent'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'categories' => 'array|exists:categories,id' // Validate categories
        ]);
    
        $article = Article::findOrFail($id);
        $article->title = $request->title;
    
        // Generate a new filename based on the updated title
        $filename = Str::slug($request->title) . date('m-d-Y_hia') . '.html';
    
        // Save the content to a file, even if it hasn't been changed
        Storage::disk('articles')->put($filename, $request->content);
    
        // Update the article's content file path with the new filename
        $article->content_file_path = $filename;
    
        $article->is_premium = $request->has('is_premium');
        $article->save();
    
        // Sync the selected categories
        $article->categories()->sync($request->categories);
    
        return redirect()->route('writer.articles.index')->with('success', 'Article updated successfully');
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        Storage::disk('articles')->delete($article->content_file_path);
        $article->categories()->detach();
        $article->delete();

        return redirect()->route('writer.articles.index')->with('success', 'Article deleted successfully');
    }
}
