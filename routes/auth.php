<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::inertia('/', 'Auth/Login' )->name('Login');

Route::middleware(['auth', RefreshPageMiddleware::class])->group(function() {
});

// Guest routes
Route::middleware(['guest', RefreshPageMiddleware::class])->group(function() { 
    Route::inertia('/register', 'Auth/Register' )->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::inertia('/login', 'Auth/Login' )->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

