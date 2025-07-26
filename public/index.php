<?php declare(strict_types=1); // public/index.php

// Define application constants
define('APP_START', microtime(true));  // Application start time for performance tracking
define('BASE_PATH', dirname(__DIR__));    // Base directory path
define('ROOT_PATH', dirname(__FILE__));   // Root directory path
define('ROOT_DIR', dirname(__FILE__));

// ✅ Load Composer Autoload FIRST
require_once BASE_PATH . '/vendor/autoload.php';

// bootstrapping
// require BASE_PATH . '/bootstrap/app.php';
// require BASE_PATH . '/bootstrap/performance.php';
$bootstrapFiles = glob(BASE_PATH . '/bootstrap/*.php');
sort($bootstrapFiles); // sort alphabetically
foreach ($bootstrapFiles as $file) {
    require_once $file;
}

// request received

// perform some logic

// send response (string of content)
echo 'Hello World';