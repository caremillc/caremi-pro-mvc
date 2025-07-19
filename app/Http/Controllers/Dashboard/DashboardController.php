<?php declare (strict_types = 1);
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Careminate\Http\Requests\Request;
use Careminate\Http\Responses\Response;
use Careminate\Logs\Contracts\LoggerInterface;

class DashboardController extends Controller
{
    public function index()
    {
        echo 'dashbaord index';
    }

     public function show(LoggerInterface $logger, Request $request, $id): Response
    {
       // $logger->info("Accessing dashboard {$id}");
        return new Response("Dashboard ID: {$id}");
    }
    
}