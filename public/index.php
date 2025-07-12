<?php declare(strict_types=1);


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

// send response (string of content)
$content = '<h1>Hello World from index page</h1>';
$response = new Response(content: $content, status: 200, headers: []);
$response->send();
