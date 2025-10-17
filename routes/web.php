<?php declare(strict_types=1);

use Careminate\Routing\Router;
use App\Http\Middleware\AuthMiddleware;

/** @var Router $router */
// $router->get('/', function () {
//     return 'Welcome to Careminate!';
// });

/** @var Router $router */
$router->get('/', function () {
    return view('home', ['title' => 'Welcome']);
});

$router->get('/page', fn() => 'This is the About page.');

/** @var Router $router */
$router->get('/', 'HomeController@index')->name('home');
$router->get('/about', 'HomeController@about')->name('about');

$router->get('/users/{id}', function ($request, $id) {
    return "User Profile ID: {$id}";
})->name('user.profile');

$router->get('/dashboard', 'HomeController@dashboard')->middleware(AuthMiddleware::class)->name('dashboard');