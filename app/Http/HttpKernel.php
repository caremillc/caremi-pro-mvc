<?php declare(strict_types=1);
namespace App\Http;

class HttpKernel
{
    
    public static array $globalWeb = [];

    public static array $middlewareWebRoute = [];

    public static array $middlewareApiRoute = [];

    public static array $globalApi = [];
}
