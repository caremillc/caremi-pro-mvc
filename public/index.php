<?php declare(strict_types=1);

use Careminate\Exceptions\Handler;
use Careminate\Http\Requests\Request;
use Careminate\Http\Responses\Response;
use Careminate\Exceptions\AuthException;

// ---------------------------------------------------------
// Bootstrap the framework
// ---------------------------------------------------------
require __DIR__ . '/../bootstrap/app.php';

// ---------------------------------------------------------
// Handle the request (placeholder)
// ---------------------------------------------------------
$request = Request::createFromGlobals();

// send response (string of content)
$content = '<h1>Hello World from index page</h1>';

$response = new Response(content: $content, status: 200, headers: []);

$response->send();