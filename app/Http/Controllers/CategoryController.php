<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
   
    public function index()
    {
        $categories = Category::all();
        $categoryNames = $categories->pluck('name')->toArray();
        return view('categories.index', ['categories' => $categories, 'categoryNames' => $categoryNames]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
        ]);

        Category::create([
            'name' => $request->name,
            'date_created' => now()
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

   
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Kiểm tra xem có task nào liên kết với category không
        if ($category->tasks()->count() > 0) {
            return redirect()->route('categories.index')->with('error', 'Category cannot be deleted because it has associated tasks.');
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}