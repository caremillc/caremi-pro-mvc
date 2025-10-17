<?php declare(strict_types=1);
namespace App\Http\Middleware;

use Careminate\Http\Requests\Request;
use Careminate\Http\Responses\Response;
use Careminate\Http\Middleware\BaseMiddleware;

class AuthMiddleware extends BaseMiddleware
{
    public function handle(Request $request): ?Response
    {
        // Example: check a fake "logged_in" query param
        if (($request->input('logged_in') ?? '0') !== '1') {
            return new Response('Access denied: not authenticated.', 403);
        }

        return null; // Continue to next layer
    }
}