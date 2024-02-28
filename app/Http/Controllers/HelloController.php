<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;

class HelloController extends Controller
{
    public function index()
    {
        return 'Hello World from HelloController!';
    }

    public function listAll()
    {
        $people = Person::all();
        //$people = Person::orderBy('age', 'asc')->get();
        //$people = Person::where('age', '>', 30)->get();
        //$people = Person::where('age', '>', 50)->orderBy('age', 'asc')->get();
        //$people = Person::where('age', '>', 50)->orderBy('age', 'asc')->limit(2)->get();
        //$people = Person::limit(2)->where('age', '>', 50)->orderBy('age', 'asc')->get();

        return $people->toJson();
    }
}
