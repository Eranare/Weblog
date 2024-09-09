<?php

namespace App\Http\Controllers\Writer;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'writer']);
    }

    public function index()
    {
        $categories = Category::all();
        return view('writer.categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('writer.categories.create', compact('categories'));
    }

    public function store(Request $request)
    {   //Check in frontend and here if name is not the same as an existing name.
        $request->validate([
            'name' => 'required',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->user_id = Auth::id();
        $category->save();

        return redirect()->route('writer.categories.create')->with('success', 'Category created successfully');
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        $articles = $category->articles;

        return view('writer.categories.show', compact('category', 'articles'));
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('writer.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->save();

        return redirect()->route('writer.categories.index')->with('success', 'Category updated successfully');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('writer.categories.index')->with('success', 'Category deleted successfully');
    }
}
