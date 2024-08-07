<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $articles = Article::all();
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $filename = Str::slug($request->title) . date('m-d-Y_hia') . '.html';
        Storage::disk('articles')->put($filename, $request->content);

        $article = new Article();
        $article->title = $request->title;
        $article->content_file_path = $filename;
        $article->user_id = auth()->id();
        $article->is_premium = $request->has('is_premium');
        $article->save();

        return redirect()->route('admin.articles.create')->with('success', 'Article created successfully');
    }

    public function show($id)
    {
        $article = Article::findOrFail($id);
        return view('admin.articles.show', compact('article'));
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $categories = Category::all();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $article = Article::findOrFail($id);
        $article->title = $request->title;

        if ($request->has('content')) {
            $filename = Str::slug($request->title) . date('m-d-Y_hia') . '.html';
            Storage::disk('articles')->put($filename, $request->content);
            $article->content_file_path = $filename;
        }

        $article->is_premium = $request->has('is_premium');
        $article->save();

        return redirect()->route('admin.articles.index')->with('success', 'Article updated successfully');
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        Storage::disk('articles')->delete($article->content_file_path);
        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Article deleted successfully');
    }
}
