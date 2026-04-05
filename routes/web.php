<?php

use App\Http\Controllers\ClapController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'feed'])->name('home');

Route::get('/topics/{category:slug}', [PostController::class, 'byCategory'])->name('posts.category');

Route::get('/read/{post}', [PostController::class, 'read'])->name('posts.read');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [PostController::class, 'dashboard'])->name('dashboard');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::post('/follow/{user}', [FollowerController::class, 'toggle'])->name('follow');
    Route::post('/posts/{post}/claps', [ClapController::class, 'store'])->name('claps.store');
});

Route::get('/{author}/{postSlug}', [PostController::class, 'show'])
    ->name('posts.show')
    ->where('author', '^@[A-Za-z0-9._-]+$')
    ->where('postSlug', '[a-zA-Z0-9_-]+');

Route::get('/{author}', [PublicProfileController::class, 'show'])
    ->name('profile.show')
    ->where('author', '^@[A-Za-z0-9._-]+$');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
