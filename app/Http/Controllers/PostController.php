<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return "List of all of the posts<br>" . Post::all()->where('public', true)->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return "Create form for a new post";
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'date' => 'nullable',
            'public' => 'required'
        ]);

        if ($validated['date'] == null) { $validated['date'] = now(); }

        $post = Post::create($validated);

        return redirect()->route('posts.show', ['post' => $post->id . ""]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);
        if (!$post) { return response("Post $id not found", 404); }

        return "Show post with id: $id<br>" . $post->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::find($id);
        if (!$post) { return response("Post $id not found", 404); }

        return "Edit form for post with id: $id<br>" . $post->toJson();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'date' => 'nullable',
            'public' => 'required'
        ]);

        if ($validated['date'] == null) { $validated['date'] = now(); }

        $post = Post::find($id);
        if (!$post) { return response("Post $id not found", 404); }

        $post->update($validated);

        return redirect()->route('posts.show', ['post' => $post->id . ""]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);
        if (!$post) { return response("Post $id not found", 404); }

        $post->delete();

        return "Post $id deleted";
    }
}
