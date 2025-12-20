<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image',
        ]);

        $category = new Category();
        $category->category_name = $request->category_name;
        $category->description = $request->description;

        // Image Upload
        if ($request->hasFile('image')) {
            $imageName = time().'_'.$request->image->getClientOriginalName();
            $request->image->move(public_path('images/categories'), $imageName);
            $category->image = $imageName;
        }

        $category->save();

        return redirect()->back()->with('success', 'Category created successfully!');
    }
}
