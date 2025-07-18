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
$request = Request::createFromGlobals();

// passing the kernel to the Container
$container = require BASE_PATH . '/config/container.php';

// Initializes the application's kernel 
$kernel =  $container->get(Kernel::class); 

$response = $kernel->handle($request);

$response->send();

dd($response);

$kernel->terminate($request, $response);
