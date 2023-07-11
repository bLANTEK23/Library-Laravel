<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('category', ['categories' =>$categories]);
    }

    public function add()
    {
        return view('category-add');
    }

    public function store(request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:categories|max:100',
        ]);
        $category = Category::create($request->all());
        return redirect('categories')->with('status', 'Category Added Seccessfuly');
    }

    public function edit($slug)
    {
        $category = Category::where('slug', $slug)->first();
        return view('category-edit', ['category' => $category]);
    }

    public function update(request $request, $slug)
    {
        $request->validate([
            'name' => 'required|unique:categories|max:100',
        ]);

        $category = Category::where('slug', $slug)->first();
        $category->slug = null;
        $category->update($request->all());
        return redirect('categories')->with('status', 'category Updated Success');
    }

    public function delete($slug)
    {
        $category = Category::where('slug', $slug)->first();
        return view ('category-delete', ['category' => $category]);
    }

    public function destory($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $category->delete();
        return redirect('categories')->with('status', 'Category delete Success');
    }

    public function deletedCategory()
    {
        $deletedCategories = Category::onlyTrashed()->get();
        return view('category-deleted-list', ['deletedCategories' => $deletedCategories]);
    }

    public function restore($slug)
    {
        $category = Category::withTrashed()->where('slug', $slug)->first();
        $category->restore();
        return redirect ('categories')->with('status', 'Category restore Succes');
    }
}
