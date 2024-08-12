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
    
        // Use a consistent directory name for the article
        $slug = Str::slug($request->title);
        $directory = "{$slug}_".date('m-d-Y_hia');
    
        // Create the directory structure using Storage
        Storage::disk('articles')->makeDirectory("{$directory}/img");  // <- Here
    
        // Log the directory path to debug
        \Log::info("Article directory: " . $directory);
    
        // Move images from the temp directory to the article's image directory
        $content = $this->moveImagesToArticleDirectory($request->content, $directory);
    
        // Save the HTML content in the correct directory
        $filename = 'content.html';
        Storage::disk('articles')->put("{$directory}/{$filename}", $content);
    
        // Log where the content is being saved
        \Log::info("Saving content to: " . storage_path("app/articles/{$directory}/{$filename}"));
    
        // Save the article information in the database
        $article = new Article();
        $article->title = $request->title;
        $article->content_file_path = "{$directory}/{$filename}";
        $article->user_id = auth()->id();
        $article->is_premium = $request->has('is_premium');
        $article->save();
    
        return redirect()->route('admin.articles.create')->with('success', 'Article created successfully');
    }
    
    private function moveImagesToArticleDirectory($content, $directory)
    {
        $document = new \DOMDocument();
        @$document->loadHTML($content);
        $images = $document->getElementsByTagName('img');
    
        foreach ($images as $img) {
            $oldSrc = $img->getAttribute('src');
            $filename = basename($oldSrc);
            $newSrc = "storage/{$directory}/img/{$filename}";
    
            // Log the image movement path
            \Log::info("Moving image from temp to: " . storage_path("app/public/{$newSrc}"));
    
            if (Storage::disk('public')->exists("temp_images/{$filename}")) {
                // Move the image to the correct img directory within the article's directory
                Storage::disk('public')->move("temp_images/{$filename}", "{$directory}/img/{$filename}");
                $content = str_replace($oldSrc, asset($newSrc), $content);
            }
        }
    
        return $content;
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
