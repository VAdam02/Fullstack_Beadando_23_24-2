<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return "List of all of the users<br>" . User::all()->toJson();
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

        return "Show user with id: $id<br>" . $user->toJson();
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
}
