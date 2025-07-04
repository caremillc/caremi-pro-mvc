<?php declare(strict_types=1);


use Careminate\Http\Kernel;
use Careminate\Http\Requests\Request;
use Careminate\Http\Responses\Response;

// Define application constants
define('APP_START', microtime(true));
define('BASE_PATH', dirname(__DIR__));
define('ROOT_PATH', dirname(__FILE__));
define('ROOT_DIR', dirname(__FILE__));

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// ✅ Bootstrap all files in /bootstrap
$bootstrapFiles = glob(BASE_PATH . '/bootstrap/*.php');
sort($bootstrapFiles);
foreach ($bootstrapFiles as $file) {
    require_once $file;
}

// Request handling
// $request = Request::createFromGlobals();

// Test env access
// $name = env('APP_NAME');
// $key  = env('APP_KEY');

// Output or use in response
// $response = Response::json([
//     'name'           => env('APP_NAME'),
//     'key'            => env('APP_KEY'),
//     'headers_sent'   => headers_sent(),
//     'output_buffering' => ob_get_level(),
//     'debug_mode'     => env('APP_DEBUG'),
//     'time'           => round(microtime(true) - APP_START, 4),
// ]);

// $response->send();


// send response (string of content)
// $content = '<h1>Hello World from index page</h1>';
// $response = new Response(content: $content, status: 200, headers: []);
// $response->send();

// throw new \Careminate\Logs\Log("Route '' not found", 404);

$request = Request::createFromGlobals();
    
$app = new Kernel();
$response = $app->handle($request);

$response->send();

$app->terminate($request, $response);

// dd($response);