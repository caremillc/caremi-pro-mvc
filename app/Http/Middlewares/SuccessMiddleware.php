<?php declare(strict_types=1);
namespace App\Http\Middlewares;

use Careminate\Http\Requests\Request;
use Careminate\Http\Responses\Response;
use Careminate\Http\Middlewares\MiddlewareInterface;
use Careminate\Http\Middlewares\RequestHandlerInterface;

class SuccessMiddleware implements MiddlewareInterface
{
    public function process(Request $request, RequestHandlerInterface $requestHandler): Response
    {
        return new Response('OMG it worked!!', 200);
    }
}