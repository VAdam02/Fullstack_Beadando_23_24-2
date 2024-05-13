<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('users.index', ['users' => User::paginate(12),
            'authorsPostCount' => User::withCount(['posts' => function ($query) { $query->where('public', true); }])->orderBy('posts_count', 'desc')->limit(8)->get(),
            'categoriesPostCount' => Category::withCount(['posts' => function ($query) { $query->where('public', true); }])->orderBy('posts_count', 'desc')->limit(8)->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return "Create form for a new user";
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'age' => 'required',
            'phone' => 'nullable',
            'password' => 'required'
        ]);

        $user = User::create($validated);

        return redirect()->route('users.show', ['user' => $user->id . ""]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        if (!$user) { return response("User $id not found", 404); }

        //list users posts
        //'posts' => Post::orderBy('date', 'desc')->where('public', true)->with('author', 'categories')->paginate(12),

        $posts = $user->posts()->orderBy('date', 'desc')->where('public', true)->with('author', 'categories')->paginate(12);

        return view('users.show', ['user' => $user,
            'posts' => $posts,
            'authorsPostCount' => User::withCount(['posts' => function ($query) { $query->where('public', true); }])->orderBy('posts_count', 'desc')->limit(8)->get(),
            'categoriesPostCount' => Category::withCount(['posts' => function ($query) { $query->where('public', true); }])->orderBy('posts_count', 'desc')->limit(8)->get()]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        if (!$user) { return response("User $id not found", 404); }

        return "Edit form for user with id: $id<br>" . $user->toJson();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,' . $id,
            'age' => 'required',
            'phone' => 'nullable',
            'password' => 'required'
        ]);

        $user = User::find($id);
        if (!$user) { return response("User $id not found", 404); }

        $user->update($validated);

        return redirect()->route('users.show', ['user' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //$user = User::findOrFail($id);

        $user = User::find($id);
        if (!$user) { return response("User $id not found", 404); }

        $user->delete();

        return redirect()->route('users.index');
    }

    public function categories()
    {
        try {
            //$users = User::all();
            //$users = User::with('posts', 'posts.categories')->get();
            $users = User::with('posts.categories')->get();

            $output = array();

            foreach ($users as $user) {
                $array = array();
                $array["name"] = $user->name;
                $array["categories"] = collect();
                foreach ($user->posts as $post) {
                    foreach ($post->categories as $category) {
                        $array["categories"]->push($category->name);
                    }
                }
                $output[] = $array;
            }

            return json_encode($output);
        }
        catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
    }
}
