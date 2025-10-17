<?php declare(strict_types=1);
namespace App\Http\Controllers;

use Careminate\Http\Requests\Request;

class HomeController extends Controller
{
     public function index(Request $request): string
    {
        return view('home', ['user' => 'Guest']);
    }

    public function about(Request $request): string
    {
        return view('about');
    }

    public function dashboard(Request $request): string
    {
        return view('dashboard');
    }
}