<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\UserController;

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
    return view('welcome');
});


Route::get('/hello1', function () {
    return 'Hello World';
});

Route::get('/hello2', [HelloController::class, 'index']);

Route::get('/listAll', [HelloController::class, 'listAll']);

//Route::get('/users', [UserController::class, 'index']);
//Route::get('/users/create', [UserController::class, 'create']);
//Route::post('/users', [UserController::class, 'store']);
//Route::get('/users/{id}', [UserController::class, 'show']);
//Route::get('/users/{id}/edit', [UserController::class, 'edit']);
//Route::put('/users/{id}', [UserController::class, 'update']);
//Route::delete('/users/{id}', [UserController::class, 'destroy']);

Route::resource('users', UserController::class);
