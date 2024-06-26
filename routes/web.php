<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('posts.index');
})->name('home');
            /*foreach ($user->categories as $category) {
                $output["categories"]->push($category->name);
            }*/

Route::get('/hello1', function () {
    return 'Hello World';
});

Route::get('/hello2', [HelloController::class, 'index']);

Route::get('/listAll', [HelloController::class, 'listAll']);

Route::get('/posts/full', [PostController::class, 'full']);

Route::get('/users/categories', [UserController::class, 'categories']);

//Route::get('/users', [UserController::class, 'index'])->name('users.index');
//Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
//Route::post('/users', [UserController::class, 'store'])->name('users.store');
//Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
//Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
//Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
//Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

Route::resource('users', UserController::class);
Route::resource('categories', CategoryController::class)->except(['index']);
//Route::resource('posts', PostController::class);
Route::post('/posts/preview', [PostController::class, 'bannerPreview'])->name('posts.preview');
Route::resource('posts', PostController::class)->except(['index'])->middleware('auth');
Route::resource('posts', PostController::class)->only(['index']);

Auth::routes();

Route::get('/home', function () {
    return redirect()->route('home');
});
