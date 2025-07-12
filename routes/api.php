<?php 

use Careminate\Routing\Route;

Route::add('GET', '/api', function () {
    return 'api anonymous route is working!';
});