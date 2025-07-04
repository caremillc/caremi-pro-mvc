<?php 


use Careminate\Routing\Route;
use App\Http\Controllers\HomeController;
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