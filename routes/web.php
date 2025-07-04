<?php 


use Careminate\Routing\Route;
use App\Http\Controllers\HomeController;
use App\Http\Middlewares\AuthMiddleware;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Comment\CommentController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Dashboard\DashboardController;


Route::get('/', function () {
    return 'Welcome!';
});

 Route::get('/home', HomeController::class, 'index');

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/home', HomeController::class, 'index');
    Route::get('/about', HomeController::class, 'about');
});

Route::prefix('admin')->middleware(['auth', 'log'])->group(function () {
    Route::get('/reports', HomeController::class, 'reports');
});

Route::middleware([App\Http\Middlewares\AuthMiddleware::class])->group(function () {
    Route::get('/dashboard', DashboardController::class, 'index');
});

// Basic resource
Route::resource('posts', PostController::class);

// Only a few methods
Route::resource('users', UserController::class)->only(['index', 'show']);

// Exclude some
Route::resource('comments', CommentController::class)->except(['create', 'edit']);

// Add middleware to all routes
Route::resource('products', ProductController::class)->middleware([AuthMiddleware::class]);