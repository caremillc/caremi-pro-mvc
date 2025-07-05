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

$container = require BASE_PATH . '/config/container.php';

$app = new Kernel();

$response = $app->handle($request);

$response->send();

$app->terminate($request, $response);

// dd($response);
