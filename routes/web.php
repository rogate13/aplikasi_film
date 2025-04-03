<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\LanguageController;

// Redirect root URL berdasarkan status auth
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('movies.index')
        : redirect()->route('login');
});

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Movie Routes
    Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
    Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.show');

    // Favorite Routes
    Route::get('/favorites', [MovieController::class, 'favorites'])->name('favorites.index');
    Route::post('/favorites', [MovieController::class, 'addFavorite'])->name('favorites.add');
    Route::delete('/favorites/{id}', [MovieController::class, 'removeFavorite'])->name('favorites.remove');
});

// Language Routes
Route::get('/language/{language}', [LanguageController::class, 'switch']);
