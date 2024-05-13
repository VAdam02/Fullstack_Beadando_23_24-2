<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //return "List of all of the categories<br>" . Category::all()->toJson();
        return view('category.categories', ["categories" => Category::orderBy('name', 'asc')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return "Create form for a new category";
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'color' => 'required'
        ]);

        $category = Category::create($validated);

        return redirect()->route('categories.show', ['category' => $category->id . ""]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);

        if (!$category) { return response("Category $id not found", 404); }

        $posts = $category->posts()->orderBy('date', 'desc')->where('public', true)->with('author', 'categories')->paginate(12);

        return view('category.show', ['category' => $category,
            'posts' => $posts,
            'authorsPostCount' => User::withCount(['posts' => function ($query) { $query->where('public', true); }])->orderBy('posts_count', 'desc')->limit(8)->get(),
            'categoriesPostCount' => Category::withCount(['posts' => function ($query) { $query->where('public', true); }])->orderBy('posts_count', 'desc')->limit(8)->get()]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::find($id);

        if (!$category) { return response("Category $id not found", 404); }

        return "Edit form for category with id: $id<br>" . $category->toJson();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'color' => 'required'
        ]);

        $category = Category::find($id);
        if (!$category) { return response("Category $id not found", 404); }

        $category->update($validated);

        return redirect()->route('categories.show', ['category' => $category->id . ""]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        if (!$category) { return response("Category $id not found", 404); }

        $category->delete();

        return redirect()->route('categories.index');
    }
}
