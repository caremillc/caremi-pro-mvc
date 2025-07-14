<?php declare(strict_types=1);

namespace App\Http\Middlewares;

use Careminate\Http\Requests\Request;
use Careminate\Http\Responses\Response;

class AuthMiddleware
{
    public function handle(Request $request, \Closure $next): Response
    {
        if (!$request->user()) {
            return redirect('/login');
        }

        return $next($request);
    }
}

