<?php

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

////con rutas  agrupadas  http://localhost/larafirststeps/public/dashboard/post

Route::group(['prefix' => 'dashboard'], function() {
    Route::resource('post', PostController::class);
    Route::resource('category', CategoryController::class);
    ////2da, forma
    Route::resources(
        [
            'post' => PostController::class,
            'category' => CategoryController::class,
        ]
        );
});
/*
Route::resource('post', PostController::class);
Route::resource('category', CategoryController::class);

Route::get('/create', [PostController::class, 'create'])->name('post.create');

Route::post('/post/store', [PostController::class, 'store'])->name('post.store');
*/
