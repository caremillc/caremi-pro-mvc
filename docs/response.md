# Careminate Framework – HTTP Response & Helpers Documentation

## Table of Contents
1. [Overview](#overview)
2. [Response System](#response-system)
   - [Response Class](#response-class)
   - [RedirectResponse Class](#redirectresponse-class)
   - [Response Methods](#response-methods)
3. [Helper Functions](#helper-functions)
4. [Environment & Configuration](#environment--configuration)
5. [Bootstrap & Front Controller](#bootstrap--front-controller)
6. [Usage Examples](#usage-examples)
7. [Error Handling](#error-handling)
8. [Logging Integration](#logging-integration)


9. [Request Response ](./request_response.md)
---

## Overview
Careminate is a lightweight PHP framework designed for modern web applications. The framework provides:

- A robust HTTP Response system (`Response` & `RedirectResponse`)
- Convenience helper functions for common tasks (`response()`, `json()`, `redirect()`, `abort()`, etc.)
- Centralized front controller for request handling (`public/index.php`)
- Configurable environment and behavior via `.env` and `config/http.php`

This guide documents how to use the response system, helpers, and bootstrap mechanism.

---

## Response System

### Response Class

**Location:** `\framework\Careminate\Http\Responses\Response.php`

The `Response` class handles content output, HTTP status codes, headers, and different content types.

#### Key Features:
- Supports `text`, `html`, `json` content types
- Handles HTTP status codes with constants and mapping
- Provides helper static methods:
  - `Response::json($data, $status = 200, $headers = [])`
  - `Response::html($html, $status = 200, $headers = [])`
  - `Response::text($text, $status = 200, $headers = [])`
  - `Response::redirect($url, $status = 302)`
  - `Response::download($filePath, $fileName = null)`
- `send()` method outputs headers and content
- Utility checks: `isSuccessful()`, `isRedirection()`, `isClientError()`, `isServerError()`

#### Example:
```php
use Careminate\Http\Responses\Response;

$response = new Response('<h1>Hello World</h1>', Response::HTTP_OK, ['X-Custom' => 'value']);
$response->send();
```
## RedirectResponse Class

Location: \framework-pro-mvc\Careminate\Http\Responses\RedirectResponse.php

RedirectResponse extends Response for handling URL redirections.

## Features:

Preserves relative URLs if configured

Supports API-aware redirects (returns JSON for AJAX/Accept: application/json)

Configurable via .env or config/http.php:

REDIRECT_PRESERVE_RELATIVE

http.redirects.preserve_relative

Provides fluent methods:

withUrl(string $url)

preserveRelative(bool $preserve)

setExitAfterRedirect(bool $exit)

## Example:
```php 
<?php
use Careminate\Http\Responses\RedirectResponse;

return new RedirectResponse('/login'); // Normal redirect
return (new RedirectResponse('/home'))->preserveRelative(); // Preserve relative path
?>

```

## Response Methods

| Method            | Description                    |
| ----------------- | ------------------------------ |
| `send()`          | Outputs headers and content    |
| `json()`          | Sends JSON response            |
| `html()`          | Sends HTML response            |
| `text()`          | Sends plain text               |
| `redirect()`      | Creates redirect response      |
| `download()`      | Sends a file download response |
| `isSuccessful()`  | Checks if 2xx status code      |
| `isClientError()` | Checks if 4xx status code      |
| `isServerError()` | Checks if 5xx status code      |
| `badRequest()`    | Returns 400 response           |
| `unauthorized()`  | Returns 401 response           |
| `forbidden()`     | Returns 403 response           |
| `notFound()`      | Returns 404 response           |
| `serverError()`   | Returns 500 response           |
| `noContent()`     | Returns 204 response           |

## Helper Functions

Location: \framework-pro-2\Careminate\Support\Helpers\functions.php

Provides convenient global functions for developers:

| Function                                | Description                                   |
| --------------------------------------- | --------------------------------------------- |
| `response($content, $status, $headers)` | Returns a basic `Response`                    |
| `json($data, $status, $headers)`        | Returns a JSON `Response`                     |
| `redirect($url, $status)`               | Returns a `RedirectResponse`                  |
| `download($filePath, $fileName)`        | Returns a file download `Response`            |
| `abort($status, $message)`              | Immediately sends error response and exits    |
| `back()`                                | Redirects to previous URL from `HTTP_REFERER` |

## Example:
```php 
<?php 
return response('<h1>Hello World</h1>');

return json(['success' => true]);

return redirect('/dashboard');

abort(404, 'Page not found');

return back();
?>

```

## Environment & Configuration
.env Variables
```bash
REDIRECT_PRESERVE_RELATIVE=true
```

# config/http.php
```php
<?php declare(strict_types=1);

return [
    'redirects' => [
        'preserve_relative' => false, // default: normalize to absolute URLs
    ],
];
?>
```
## REDIRECT_PRESERVE_RELATIVE or http.redirects.preserve_relative controls whether relative URLs are preserved during redirects.

Bootstrap & Front Controller

Location: public/index.php

Loads framework bootstrap (bootstrap/app.php)

## Initializes request object:
```php 
<?php 
$request = Request::createFromGlobals();
?>
```

## Creates and sends a response:
```php 
<?php 

$response = new Response('<h1>Hello World</h1>', 200);
$response->send();
?>
``` 

# Handles exceptions via try-catch:
```php 
<?php 

try {
    // Your request handling logic
} catch (\Throwable $e) {
    logException($e); // Logs error
}
?>
```

# Usage Examples
HTML Response
```php 
<?php 

return response('<h1>Welcome</h1>', Response::HTTP_OK);
?>
```

# JSON Response
```php 
<?php 
return json(['message' => 'Success'], Response::HTTP_OK);
?>
```

# Redirect
```php 
<?php 
return redirect('/login');
?>
```

# File Download
```php 
<?php 
return download('/path/to/file.pdf', 'report.pdf');
?>
```

# Abort Request
```php 
<?php 
abort(403, 'Access denied');
?>
```

## Error Handling

Use abort($status, $message) for immediate error responses.

Framework provides default helpers for common HTTP statuses:
```php 
<?php 
Response::badRequest()

Response::unauthorized()

Response::forbidden()

Response::notFound()

Response::serverError()
?>
```

# Logging Integration

The framework supports logging exceptions and events:
```php 
<?php 

logger('default')->info('App booted');
logger('errors')->error('Database connection failed');
logger('security')->warning('Unauthorized login attempt');
?>

```
## Logs are stored under storage/logs/.
---

