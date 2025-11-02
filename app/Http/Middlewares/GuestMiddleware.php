<?php declare(strict_types=1);
namespace App\Http\Middlewares;

use Careminate\Session\Session;
use Careminate\Http\Requests\Request;
use Careminate\Http\Responses\Response;
use Careminate\Session\SessionInterface;
use Careminate\Http\Responses\RedirectResponse;
use Careminate\Http\Middlewares\MiddlewareInterface;
use Careminate\Http\Middlewares\RequestHandlerInterface;

class GuestMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly SessionInterface $session,
        private readonly string $redirectTo = "/admin/dashboard"
    ) {}

    public function process(Request $request, RequestHandlerInterface $handler): Response
    {

        // Ensure session is available (StartSession middleware must run first)
        if ($this->session->has(Session::AUTH_KEY)) {
            // dd(Session::AUTH_KEY);
            // dd($this->redirectTo);
            // return new Redirect($this->redirectTo);
            // or
            return (new RedirectResponse())->to($this->redirectTo);
        } 
        
        // else {
        //     // return new Redirect('/login');
        //     // or
        //     return (new Redirect())->to('/');
        // }

        return $handler->handle($request);
    }
}

