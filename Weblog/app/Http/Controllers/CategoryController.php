<?php

// app/Http/Controllers/CategoryController.php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{


    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }


    public function show($id)
    {
        $category = Category::findOrFail($id);
        $articles = $category->articles; // Get all articles related to this category
        
        return view('categories.show', compact('category', 'articles'));
    }
}