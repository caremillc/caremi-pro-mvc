<?php declare (strict_types = 1);

use Careminate\Routing\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\Dashboard\DashboardController;

// Closure route
Route::get('/', function () {
    return 'anonymous route is working!';
});

Route::get('/home', HomeController::class, 'index');

Route::prefix('front')->middleware(['auth'])->group(function () {
    Route::get('/posts', PostController::class, 'index');
 });

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', DashboardController::class, 'index');
});

Route::middleware([App\Http\Middlewares\AuthMiddleware::class])->group(function () {
    Route::get('/dashboard', DashboardController::class, 'index');
    Route::get('dashboard/{id}/show', DashboardController::class, 'show');
});


// Basic resource
Route::resource('posts', PostController::class);

// Only a few methods
Route::resource('users', \App\Http\Controllers\User\UserController::class);

// Only a few methods
Route::resource('users', \App\Http\Controllers\User\UserController::class)->only(['index', 'show']);

// Exclude some
Route::resource('users', \App\Http\Controllers\User\UserController::class)->except(['create', 'edit']);

// Add middleware to all routes
Route::resource('products', PostController::class)->middleware([App\Http\Middlewares\AuthMiddleware::class]);