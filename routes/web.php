<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::get('posts', [PostController::class, 'index']);
Route::middleware('auth')->group(function () {
    Route::post('posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('posts/create', [PostController::class, 'create'])->middleware('auth');
    Route::delete('post/{id}/delete', [PostController::class, 'destroy']);
    Route::get('post/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('post/{id}/update', [PostController::class, 'update'])->name('posts.update');
});

Route::get('post/{id}', [PostController::class, 'show'])->name('posts.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
