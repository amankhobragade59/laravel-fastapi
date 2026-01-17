<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TodoController;

Route::controller(PostController::class)->group(function () {
    Route::get('/', 'index')->name('posts.index');
    // Route::get('/posts', 'index');
    Route::get('/posts/fetch', 'fetch');
    Route::get('/posts/create', 'create')->name('posts.create');
    Route::get('/posts/{id}/view', 'view')->name('posts.view');
});

Route::prefix('users')->controller(UserController::class)->group(function () {
    Route::get('/', 'index')->name('users.index');
    Route::get('/fetch', 'fetch');
});


Route::prefix('todos')->controller(TodoController::class)->group(function () {
    Route::get('/', 'index')->name('todos.index');
    Route::get('/fetch', 'fetch');
});