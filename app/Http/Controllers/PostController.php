<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    /*
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }
    */

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('posts.index', ['posts' => Post::orderBy('date', 'desc')->where('public', true)->with('author', 'categories')->paginate(12),
                                   'highlightposts' => Post::orderBy('date', 'desc')->where('public', true)->with('author', 'categories')->take(5)->get(),
                                   'authorsPostCount' => User::withCount(['posts' => function ($query) { $query->where('public', true); }])->orderBy('posts_count', 'desc')->limit(8)->get(),
                                   'categoriesPostCount' => Category ::withCount(['posts' => function ($query) { $query->where('public', true); }])->orderBy('posts_count', 'desc')->limit(8)->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create', ['categories' => Category ::withCount(['posts' => function ($query) { $query->where('public', true); }])->orderBy('posts_count', 'desc')->get(),
                                    'authorsPostCount' => User::withCount(['posts' => function ($query) { $query->where('public', true); }])->orderBy('posts_count', 'desc')->limit(8)->get(),
                                    'categoriesPostCount' => Category ::withCount(['posts' => function ($query) { $query->where('public', true); }])->orderBy('posts_count', 'desc')->limit(8)->get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255|min:3|unique:posts',
            'content' => 'required|max:10000|min:3',
            'date' => 'nullable|date',
            'public' => 'nullable',
            'categories' => 'nullable|array|exists:categories,id'
        ],
        [
            'title.required' => 'A cím megadása kötelező!',
            'title.max' => 'A cím maximum 255 karakter hosszú lehet!',
            'title.min' => 'A cím minimum 3 karakter hosszú kell legyen!',
            'title.unique' => "A címnek egyedinek kell lennie!",
            'content.required' => 'A tartalom megadása kötelező!',
            'content.max' => 'A tartalom maximum 10000 karakter hosszú lehet!',
            'content.min' => 'A tartalom minimum 3 karakter hosszú kell legyen!',
            'date.date' => 'A dátum formátuma nem megfelelő!',
            'categories.array' => 'A kategóriák formátuma nem megfelelő!',
            'categories.exists' => 'A kategóriák közül legalább egy nem létezik!'
        ]);

        $validated['public'] = isset($validated['public']);
        if (!isset($validated["date"])) { $validated['date'] = now(); }

        $post = Post::make($validated);

        //TODO set to the logged in user
        $post->author()->associate(User::find(1));

        $post->save();

        if (isset($validated['categories'])) { $post->categories()->sync($validated['categories']); }

        Session::flash('success', 'Post successfully created!');

        return redirect()->route('posts.show', ['post' => $post->id . ""]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);
        if (!$post) {
            Session::flash('error', 'Post not found!');
            return redirect()->route('posts.index');
        }

        return view('posts.show', ['post' => $post,
                                   'authorsPostCount' => User::withCount(['posts' => function ($query) { $query->where('public', true); }])->orderBy('posts_count', 'desc')->limit(8)->get(),
                                   'categoriesPostCount' => Category ::withCount(['posts' => function ($query) { $query->where('public', true); }])->orderBy('posts_count', 'desc')->limit(8)->get()]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::find($id);
        if (!$post) {
            Session::flash('error', 'Post not found!');
            return redirect()->route('posts.index');
        }

        return view('posts.edit', ['post' => $post,
                                   'categories' => Category ::withCount(['posts' => function ($query) { $query->where('public', true); }])->orderBy('posts_count', 'desc')->get(),
                                   'authorsPostCount' => User::withCount(['posts' => function ($query) { $query->where('public', true); }])->orderBy('posts_count', 'desc')->limit(8)->get(),
                                   'categoriesPostCount' => Category ::withCount(['posts' => function ($query) { $query->where('public', true); }])->orderBy('posts_count', 'desc')->limit(8)->get()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required|max:255|min:3|unique:posts,title,' . $id,
            'content' => 'required|max:10000|min:3',
            'date' => 'nullable|date',
            'public' => 'nullable',
            'categories' => 'nullable|array|exists:categories,id'
        ],
        [
            'title.required' => 'A cím megadása kötelező!',
            'title.max' => 'A cím maximum 255 karakter hosszú lehet!',
            'title.min' => 'A cím minimum 3 karakter hosszú kell legyen!',
            'title.unique' => "A címnek egyedinek kell lennie!",
            'content.required' => 'A tartalom megadása kötelező!',
            'content.max' => 'A tartalom maximum 10000 karakter hosszú lehet!',
            'content.min' => 'A tartalom minimum 3 karakter hosszú kell legyen!',
            'date.date' => 'A dátum formátuma nem megfelelő!',
            'categories.array' => 'A kategóriák formátuma nem megfelelő!',
            'categories.exists' => 'A kategóriák közül legalább egy nem létezik!'
        ]);

        if ($validated['date'] == null) { $validated['date'] = now(); }

        $post = Post::find($id);
        if (!$post) {
            Session::flash('error', 'Post not found!');
            return redirect()->route('posts.index');
        }

        $post->update($validated);

        if (isset($validated['categories'])) { $post->categories()->sync($validated['categories']); }

        Session::flash('success', 'Post successfully updated!');

        return redirect()->route('posts.show', ['post' => $post->id . ""]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);

        if (Gate::denies('delete-post', $post)) {
            Session::flash('error', 'You are not authorized to delete this post!');
            return redirect()->route('posts.show', ['post' => $post->id . ""]);
        }

        if (!$post) {
            Session::flash('error', 'Post not found!');
            return redirect()->route('posts.index');
        }

        $post->delete();

        Session::flash('success', 'Post successfully deleted!');

        return redirect()->route('posts.index');
    }

    public function full()
    {
        //$posts = Post::all();
        $posts = Post::with('author', 'categories')->get();

        foreach ($posts as $post) {
            $post->author;
            $post->categories;
        }

        return $posts->toJson();
    }
}
