<?php declare(strict_types=1);

use Careminate\Http\Responses\Response;
use App\Http\Middlewares\DummyMiddleware;
use App\Http\Middlewares\GuestMiddleware;
use Careminate\Http\Middlewares\Authenticate;

return [
    ['GET', '/', [App\Http\Controllers\HomeController::class, 'index']],

    ['GET', '/posts', [App\Http\Controllers\Post\PostController::class, 'index']],
    ['GET', '/posts/create', [App\Http\Controllers\Post\PostController::class, 'create']],
    ['POST', '/posts/store', [App\Http\Controllers\Post\PostController::class, 'store']],
    ['GET', '/posts/{id:\d+}/show', [\App\Http\Controllers\Post\PostController::class, 'show']],
    ['GET', '/posts/{id:\d+}/edit', [App\Http\Controllers\Post\PostController::class, 'edit']],
    ['PUT', '/posts/{id:\d+}/update', [App\Http\Controllers\Post\PostController::class, 'update']],
    ['DELETE', '/posts/{id}/delete', [App\Http\Controllers\Post\PostController::class, 'destroy']],

    //register
    ['GET', '/register', [\App\Http\Controllers\Auth\RegistrationController::class, 'index'
    ,[GuestMiddleware::class]
    ]],
    ['POST', '/register', [\App\Http\Controllers\Auth\RegistrationController::class, 'register']],

    //login
    ['GET', '/login', [\App\Http\Controllers\Auth\LoginController::class, 'loginForm'
  ,[GuestMiddleware::class]
    ]],
    ['POST', '/login', [\App\Http\Controllers\Auth\LoginController::class, 'login']],
    // logout
     ['GET', '/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout',[Authenticate::class]]],
    //dashboard
    ['GET', '/admin/dashboard', [\App\Http\Controllers\Dashboard\DashboardController::class, 'index'
    , [Authenticate::class, DummyMiddleware::class]
    ]],
    
    //response
    ['GET', '/Hello/{name:.+}', function (string $name) {
        return new Response("Hello $name");
    }],
];