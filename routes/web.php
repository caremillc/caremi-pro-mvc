<?php 


use Careminate\Routing\Route;
use App\Http\Controllers\HomeController;


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