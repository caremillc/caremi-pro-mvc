<?php declare(strict_types=1);

use Careminate\Routing\Route;

// Closure route
Route::get('/api', function () {
    $user= ['name'=>'eric'];
   return response()->json(['user' => $user]);
});