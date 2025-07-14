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
});