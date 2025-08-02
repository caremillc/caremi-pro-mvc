# HTTP Response System

## Overview

The `Careminate\Http\Responses\Response` class provides a powerful and expressive way to return responses from your application. It supports various content types, HTTP status codes, headers, redirections, and output buffering.

All responses are handled using either the `Response` or `RedirectResponse` class.

---

# Table of Contents
 
## Introduction

    ## Response Types

    ## JSON Responses

    ## XML Responses

    ## Text/HTML Responses

    ## File Responses

    ## Error Responses

## Response Class

## Redirect Responses

## Helpers

## Configuration

## Best Practices



# Response Types
## JSON Responses

Create JSON responses with proper headers and status codes:
```php

use Careminate\Http\Responses\Response;

// Basic JSON response
$response = Response::json(['data' => $value]);

// With custom status
$response = Response::json(['error' => 'Not found'], 404);

// With headers
$response = Response::json($data, 200, ['X-Custom' => 'Value']);

// Streaming JSON for large datasets
$response = Response::streamJson($largeDataset);

// Simple JSON response
$response = Response::json(['message' => 'Success']);

// Success/error helpers
$success = Response::success('Operation completed', ['id' => 123]);

$error = Response::error('Validation failed', ['email' => 'Invalid']);

// Fluent JSON
$response = response()->withJson(['data' => $value]);
```


# XML Responses

Generate XML responses from arrays or strings:
```php

// From array
$response = Response::xml(['item' => ['id' => 1, 'name' => 'Test']]);

// From string with custom root
$response = Response::xml('<items><item>1</item></items>', 200, [], 'catalog');

$xml = Response::xml(['user' => ['name' => 'John']]);

```


# Text/HTML Responses

Return plain text or HTML responses:
```php

// Plain text
$response = Response::text('Hello World');

// HTML
$response = Response::html('<h1>Welcome</h1>');

// Common HTTP responses
$response = Response::unauthorized();
$serverError = Response::serverError();
$response = Response::serverError('Custom error message');

// Plain text
$text = Response::text('Plain text content');

// HTML
$html = Response::html('<h1>Welcome</h1>');

// Predefined error responses
$notFound = Response::notFound();


```

 
# File Responses

Handle file downloads and streaming:
```php

// File download
$response = Response::download('/path/to/file.pdf', 'document.pdf');

// Stream with callback
$response = Response::stream(function() {
    // Generate content on the fly
});

$response = Response::download('/path/to/file.pdf');

// With custom filename
$response = Response::download('/path/to/file.pdf', 'document.pdf');

```


# Error Responses

Handle exceptions and errors:
```php

try {
    // Application code
} catch (Throwable $e) {
    $response = Response::fromThrowable($e);
    $response->send();
}

```


 # Response Class

The Response class provides core functionality with these key methods:
## Core Methods
```php

// Create response
$response = new Response('content', 200, $headers);

// Send response
$response->send();

// Get/set content
$content = $response->getContent();
$response->setContent('new content');

// Get/set status
$status = $response->getStatus();
$response->status(404);

// Headers management
$response->setHeader('X-Custom', 'Value');
$header = $response->getHeader('X-Custom');
```
# Fluent Methods
```php

// Chainable methods
$response->content('Hello')
         ->status(200)
         ->setHeader('Content-Type', 'text/plain');
```
# Security Headers
```php

// Add security headers
$response->withSecurityHeaders();

// Custom CSP policy
$response->withCsp("default-src 'self'");
```

# HTTP/2 Features
```php

// Server push
$response->withPush('/assets/app.js', 'script');

// Resource preloading
$response->withPreload('/assets/style.css', 'style');
```
# Redirect Responses

Handle HTTP redirects:
```php

use Careminate\Http\Responses\RedirectResponse;

// Basic redirect
$redirect = new RedirectResponse('/new-location');

// Custom status
$redirect = new RedirectResponse('/moved', 301);

// Without exiting
$redirect->setExitAfterRedirect(false);

// Using helper
redirect('/dashboard')->send();
```
# Helpers

Convenience functions for common operations:
```php

// Create response
response('Hello')->send();

// Redirect
redirect('/login')->send();

// Debug logging
debug_log($data);
debug_log($data, true); // Log to file

// Abort with error
abort(404, 'Page not found');

// Set custom JSON serializer
json_serializer(function($data) {
    return custom_json_encode($data);
});
```
# Configuration

Configure responses in .env:
```bahs

APP_DEBUG=true
APP_ENV=dev
```
# Response settings in config/app.php:
```php

return [
    'debug' => filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOL),
    // Other settings...
];
```
Best Practices

    Use proper status codes: Always set appropriate HTTP status codes

    Security headers: Apply withSecurityHeaders() for production responses

    Error handling: Use Response::fromThrowable() for consistent error responses

    Memory management: Large responses should use streaming

    Content negotiation: Check Accept header and respond appropriately

    Caching: Use withCache() for cacheable responses

    JSON options: Set default JSON encoding options via Response::setJsonOptions()

# Example workflow:
```php

try {
    $data = $service->getData();
    
    return Response::json($data)
        ->withSecurityHeaders()
        ->withCache(3600);
} catch (NotFoundException $e) {
    return Response::json(['error' => $e->getMessage()], 404);
} catch (Throwable $e) {
    logger()->error($e);
    return Response::fromThrowable($e);
}
```
This documentation covers the core functionality of the Careminate Response System. Refer to the source code for additional details on implementation.

 

# Stream Responses
```php

$response = Response::stream(function() {
    echo "Streaming data...";
    flush();
});
```
# HTTP Status Codes

## Common status code constants:
```php

Response::HTTP_OK // 200
Response::HTTP_CREATED // 201
Response::HTTP_NO_CONTENT // 204
Response::HTTP_BAD_REQUEST // 400 
Response::HTTP_UNAUTHORIZED // 401
Response::HTTP_FORBIDDEN // 403
Response::HTTP_NOT_FOUND // 404
Response::HTTP_INTERNAL_SERVER_ERROR // 500
```
# Headers
```php

// Set headers
$response = new Response();
$response->setHeader('X-Custom', 'Value');

// Multiple headers
$response->withHeaders([
    'X-Header-One' => 'First',
    'X-Header-Two' => 'Second'
]);

// Get headers
$value = $response->getHeader('X-Custom');
```
# Macros

## Extend response functionality:
```php

// Define a macro
Response::macro('uppercase', function(string $content) {
    return $this->content(strtoupper($content));
});

// Use the macro
$response = response()->uppercase('hello'); // "HELLO"
```

# RedirectResponse Class

The RedirectResponse class handles HTTP redirects with proper status codes.
## Basic Redirects
```php

use Careminate\Http\Responses\RedirectResponse;

// Simple redirect (302 Found by default)
$redirect = new RedirectResponse('/new-location');

// With helper
$redirect = redirect('/dashboard');

// Permanent redirect (301)
$redirect = new RedirectResponse('/new-location', RedirectResponse::HTTP_MOVED_PERMANENTLY);
```

# Advanced Redirects
```php

// Disable auto-exit after redirect
$redirect = redirect('/profile')
    ->setExitAfterRedirect(false);

// Change URL after creation
$redirect = redirect('/old')
    ->withUrl('/new');

// Add headers
$redirect = redirect('/login')
    ->withHeaders(['X-Redirected-From' => '/protected']);
```

# Setting Status Codes

## You can set the status code using the constructor or fluent setStatus():

```php
$response = new Response('Created', Response::HTTP_CREATED);
```
# or

```php
$response->setStatus(Response::HTTP_NO_CONTENT);
```

# Setting Headers

## Set headers using:
```php
$response->setHeader('X-Framework', 'Careminate');
$response->setHeaders([
    'Cache-Control' => 'no-cache',
    'Content-Type' => 'application/json',
]);
```

# To retrieve or remove headers:
```php
$value = $response->getHeader('X-Framework');
$response->removeHeader('Cache-Control');
```

# JSON Responses

## Return JSON data with:
```php
$response = (new Response())->json([
    'success' => true,
    'message' => 'Data retrieved successfully',
]);
$response->send();
```

# You may configure global JSON encoding behavior:
```php
Response::setJsonOptions(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
```

# HTML & Text Responses
## HTML:
```php
$response = Response::html('<h1>Welcome</h1>');
```

# Plain Text:
```php
$response = Response::text('Plain text response');
```

# Both accept optional status and headers:
```php
Response::html('<p>Thanks</p>', Response::HTTP_ACCEPTED, ['X-Custom' => 'Yes']);
```

# Redirection

## Use the redirect() method to redirect:
```php
$response = (new Response())->redirect('/login');
$response->send();
```

# Or use the dedicated RedirectResponse:
```php
use Careminate\Http\Responses\RedirectResponse;

$response = new RedirectResponse('/dashboard');
$response->send();
```

# You can control behavior:
```php 
$response->setExitAfterRedirect(false); // do not exit after send()
$response = $response->withUrl('/profile');
``` 

# Common Error Helpers

## Use static helpers for common errors:
```php 
return Response::notFound();             // 404 Not Found
return Response::badRequest();           // 400 Bad Request
return Response::unauthorized();         // 401 Unauthorized
return Response::forbidden();            // 403 Forbidden
return Response::serverError();          // 500 Internal Server Error
return Response::noContent();            // 204 No Content

```
## All helpers allow optional messages or headers.

# Status Checking Methods

## These allow conditional logic:
```php 
$response->isSuccessful();    // true if 2xx
$response->isRedirection();   // true if 3xx
$response->isClientError();   // true if 4xx
$response->isServerError();   // true if 5xx
```

# Output Buffering

## Output buffering is enabled by default to capture exceptions during rendering.

## You can disable it if needed:
```php 
$response->setOutputBuffering(false);
```

# Example (from public/index.php)
```php 

use Careminate\Http\Responses\Response;

$response = new Response('Hello World! from index');

$response->setHeader('X-Powered-By', 'Careminate');
$response->send();

```
# Helpers
## response()
```php

// Create responses
$response = response('Content', 200, $headers);

// Fluent interface
response()
    ->status(201)
    ->content('Created')
    ->setHeader('Location', '/new-resource')
    ->send();
```
# redirect()
```php

// Simple redirect
redirect('/home');

// With status code
redirect('/login', Response::HTTP_TEMPORARY_REDIRECT);
```
# env()
```php

// Get environment variables
$debug = env('APP_DEBUG', false);
```
# Examples
## JSON API Response
```php

return Response::json([
    'success' => true,
    'data' => $resource,
    'meta' => ['page' => 1]
], Response::HTTP_OK);
```
# File Download
```php

return Response::download(
    storage_path('reports/report.pdf'),
    'monthly-report.pdf'
);
```
# Error Handling
```php

try {
    // Some operation
} catch (Exception $e) {
    return Response::fromThrowable($e);
}
```
# Custom Redirect
```php

return redirect('/login')
    ->setExitAfterRedirect(false)
    ->withHeaders(['X-Redirect-Reason' => 'unauthorized']);
```
# Macro Example
```php

// Define in bootstrap/macros.php
Response::macro('xmlResponse', function(array $data) {
    return $this->withHeaders(['Content-Type' => 'application/xml'])
        ->content($this->toXml($data));
});

// Usage
return response()->xmlResponse($data);
```
 
This documentation covers all major use cases of the Response and RedirectResponse classes in the framework. 
The fluent interface and helper methods provide a clean way to build responses while maintaining proper HTTP semantics.
