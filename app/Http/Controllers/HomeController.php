<?php declare(strict_types=1);
namespace App\Http\Controllers;

use App\Widget\Widget;
use Careminate\Validation\Validate;
use Careminate\Http\Requests\Request;
use Careminate\Http\Responses\Response;

class HomeController extends Controller 
{
     public function __construct(private Widget $widget)
    {
    }

    public function index(): Response
    {
        $content = "<h1>Hello {$this->widget->name}</h1>";

        return new Response($content);
    }
    
    // public function index(): Response
    // {
    //     return response('Welcome Home!', Response::HTTP_OK);
    //     return response()->json(['user' => $user]);
    //     return response()->xml(['status' => 'ok']);
    //     return redirect('/dashboard');
    //     return response()->redirect('/login');
    //     return Response::success('User created', ['id' => 123]);
    //     return Response::error('Validation failed', ['email' => 'Email is required']);
    //     return Response::fromThrowable($exception);
    //     return response()->json(['custom' => true]); // using helper
    // }

    //  public function store(Request $request)
    // {
    //     $data = [
    //         'email'                 => 'test@example.com',
    //         'password'              => 'secret123',
    //         'password_confirmation' => 'secret123',
    //         'role'                  => 'admin',
    //     ];

    //     $rules = [
    //         'email'    => 'required|email',
    //         'password' => 'required|min:8|confirmed',
    //         'role'     => 'in:admin,user,editor',
    //     ];

    //     $validator = new Validate($data, $rules);

    //     if ($validator->fails()) {
    //         dd($validator->errors());
    //     }

    // }

    // public function reports():Response
    // {
    //        return response('Welcome Reports!', Response::HTTP_OK);
    // }
   
    
}
