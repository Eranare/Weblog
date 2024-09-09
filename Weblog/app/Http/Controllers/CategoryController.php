<?php

// app/Http/Controllers/CategoryController.php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{


    public function show($id)
    {
        // Fetch the category
        $category = Category::findOrFail($id);

        // Get articles that belong to this category, paginate results
        $articles = $category->articles()
            ->where('is_flagged_for_deletion', false) // Only pull articles that are not hidden
            ->orderBy('created_at', 'desc')  // Sort by newest first
            ->paginate(10);

        // Return the view with category and its articles
        return view('categories.show', compact('category', 'articles'));
    }
    // Fetch top 6 popular categories
    public function getPopularCategories()
    {
        // Assuming "articles" is the relationship with categories
        $popularCategories = Category::withCount('articles')
            ->orderBy('articles_count', 'desc')  // Order by the number of articles in each category
            ->take(6)  // Limit to top 6 categories
            ->get();

        return response()->json($popularCategories);
    }

    // Search categories by name based on user input
    public function searchCategories(Request $request)
    {
        $query = $request->input('query');

        $categories = Category::where('name', 'LIKE', "%{$query}%")->get();

        return response()->json($categories);
    }
}