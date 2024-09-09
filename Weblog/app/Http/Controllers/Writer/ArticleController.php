<?php

namespace App\Http\Controllers\Writer;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'writer']);
    }

    public function index()
    {
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
            'categories' => 'array|exists:categories,id',
            'banner_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048' // Validation for image
        ]);
    
        // Create a unique directory for the article
        $articleDir = Str::slug($request->title) . '-' . Str::random(6);
        $filename = $articleDir . '/' . Str::slug($request->title) . date('m-d-Y_hia') . '.html';
    
        // Update image paths in the content
        $content = $this->updateImagePathsInContent($request->content, $articleDir);
    
        // Store the content file
        Storage::disk('articles')->put($filename, $content);
    
        $bannerImagePath = null;
    
        // Handle banner image
        if ($request->hasFile('banner_image')) {
            // Store the banner image in the public directory and get the public URL
            $bannerImagePath = $request->file('banner_image')->store('banners', 'public');
    
            // Use Storage::url() to generate the publicly accessible path
            $bannerImagePath = Storage::url($bannerImagePath); 
        } else {
            // Extract the first image from the content if no banner image is uploaded
            $bannerImagePath = $this->extractFirstImageFromContent($content, $articleDir);
        }
    
        // Generate content preview
        $contentPreview = $this->generateContentPreview($content);
    
        $article = new Article();
        $article->title = $request->title;
        $article->content_file_path = $filename;
        $article->content_preview = $contentPreview;
        $article->banner_image_path = $bannerImagePath;
        $article->user_id = auth()->id();
        $article->is_premium = $request->has('is_premium');
        $article->save();
    
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
            'categories' => 'array|exists:categories,id',
            'banner_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048' // Validation for image
        ]);
    
        $article = Article::findOrFail($id);
    
        // Create a unique directory for the article if it doesn't exist
        $articleDir = Str::slug($request->title) . '-' . Str::random(6);
        $filename = $articleDir . '/' . Str::slug($request->title) . date('m-d-Y_hia') . '.html';
    
        // Store the content file
        $content = $this->updateImagePathsInContent($request->content, $articleDir);
        Storage::disk('articles')->put($filename, $content);
        $article->content_file_path = $filename;
    
        // Handle banner image
        if ($request->hasFile('banner_image')) {
            // Store the banner image in the public directory
            $bannerImagePath = $request->file('banner_image')->store('banners', 'public');
    
            // Use Storage::url() to generate the publicly accessible path
            $bannerImagePath = Storage::url($bannerImagePath); // Will result in /storage/banners/filename.jpg
        } else {
            // Extract the first image from the content if no banner image is uploaded
            $bannerImagePath = $this->extractFirstImageFromContent($content, $articleDir);
        }
    
        $article->banner_image_path = $bannerImagePath;
    
        // Generate content preview
        $contentPreview = $this->generateContentPreview($request->content);
        $article->content_preview = $contentPreview;
    
        $article->is_premium = $request->has('is_premium');
        $article->save();
        $article->categories()->sync($request->categories);
    
        return redirect()->route('writer.articles.index')->with('success', 'Article updated successfully');
    }
    

    public function hide($id)
    {
        $article = Article::findOrFail($id);
        $article->is_flagged_for_deletion = true;
        $article->save();

        return redirect()->route('writer.articles.index')->with('success', 'Article hidden successfully');
    }

    public function unhide($id)
    {
        $article = Article::findOrFail($id);
        $article->is_flagged_for_deletion = false;
        $article->save();

        return redirect()->route('writer.articles.index')->with('success', 'Article unhidden successfully');
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        Storage::disk('articles')->delete($article->content_file_path);
        Storage::disk('articles')->deleteDirectory(dirname($article->content_file_path)); // Delete the article directory
        $article->categories()->detach();
        $article->delete();

        return redirect()->route('writer.articles.index')->with('success', 'Article deleted successfully');
    }

    // Method to extract the first image URL from the content and save it in the article's directory
    private function extractFirstImageFromContent($content, $articleDir)
    {
        $dom = new \DOMDocument();
        @$dom->loadHTML($content); // Use '@' to suppress warnings from invalid HTML

        $images = $dom->getElementsByTagName('img');
        if ($images->length > 0) {
            $firstImageSrc = $images->item(0)->getAttribute('src');

            // If the image source starts with "/storage", convert it to the absolute path
            if (strpos($firstImageSrc, '/storage/') !== false) {
                // Generate the file path on the server for public storage
                $firstImageSrc = public_path(str_replace('/storage/', 'storage/', $firstImageSrc));
            } elseif (strpos($firstImageSrc, 'http') === false) {
                // Handle case for relative URLs
                $firstImageSrc = asset($firstImageSrc);
            }

            // Fetch the image content and save it to the public storage
            $imageContent = file_get_contents($firstImageSrc);
            $imageName = basename($firstImageSrc);
            $imagePath = 'banners/' . $imageName;

            Storage::disk('public')->put($imagePath, $imageContent);

            return Storage::disk('public')->url($imagePath);
        }

        return null; // No image found
    }

    private function generateContentPreview($content)
    {
        $content = strip_tags($content); // Strip HTML tags
        $content = Str::limit($content, 150); // Limit to 150 characters

        return $content;
    }

    private function updateImagePathsInContent($content, $articleDir)
    {
        $dom = new \DOMDocument();
        @$dom->loadHTML($content); // Suppress warnings

        $images = $dom->getElementsByTagName('img');
        foreach ($images as $img) {
            $src = $img->getAttribute('src');
            if (strpos($src, '/storage/temp_images/') !== false) {
                $imageName = basename($src);
                $newPath = '/storage/articles/' . $articleDir . '/img/' . $imageName;
                $img->setAttribute('src', $newPath);

                // Move the image to the correct directory
                Storage::disk('public')->move('temp_images/' . $imageName, 'articles/' . $articleDir . '/img/' . $imageName);
            }
        }

        return $dom->saveHTML();
    }
}
