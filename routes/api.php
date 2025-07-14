<?php declare (strict_types = 1);

use Careminate\Routing\Route;

Route::add('GET', '/api', function () {
    $user= ['name'=>'eric'];
   return response()->json(['user' => $user]);
});