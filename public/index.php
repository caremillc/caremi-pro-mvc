<?php declare(strict_types=1);

use Careminate\Http\Requests\Request;

define('APP_START', microtime(true));
define('BASE_PATH', dirname(__DIR__));
define('ROOT_PATH', __DIR__); // single definition

require_once BASE_PATH . '/vendor/autoload.php';

// Bootstrapping in a controlled order
require_once BASE_PATH . '/bootstrap/app.php';
require_once BASE_PATH . '/bootstrap/performance.php';

// Create request from globals
$request  = Request::createFromGlobals();
// dd($request);
   
