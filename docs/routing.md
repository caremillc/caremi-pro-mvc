# Careminate Framework Routing Documentation

## Table of Contents

    Introduction

    Routing Basics

    Route Definitions

    Route Parameters

    Route Groups

    Middleware

    Response Handling

    Error Handling

    API Routes

    Best Practices

## Introduction

The Careminate Framework provides a powerful routing system that handles both web and API routes with support for:

    Closure-based routes

    Controller-based routes

    Route parameters

    Middleware

    Multiple HTTP methods

    Automatic route registration

# Routing Basics
## File Structure

Routes are defined in:

    Web routes: routes/web.php

    API routes: routes/api.php

## Routes are automatically loaded based on the first URI segment.
HTTP Methods Supported

    GET

    POST

    PUT

    PATCH

    DELETE

# Route Definitions
## Closure Routes
```php

Route::get('/', function () {
    return 'Anonymous route is working!';
});
```
# Controller Routes
```php

Route::get('/home', HomeController::class, 'index');
```
# Route Parameters
## Basic Parameters
```php

Route::get('/article/{id}/{slug}', HomeController::class, 'article');
```
The controller method should accept these parameters:
```php

public function article($id, $slug = ''): string
{
    return "Welcome to article {$id} with slug {$slug}";
}
```
# Route Groups
## Web Routes

All routes in web.php are automatically prefixed with web middleware.
API Routes

All routes in api.php are automatically prefixed with api/ and API middleware.
Middleware
# Adding Middleware
```php

Route::get('/admin', AdminController::class, 'index', ['auth', 'admin']);
```
# Response Handling
## Available Responses
```php

// Basic response
return response('Welcome!', Response::HTTP_OK);

// JSON response
return response()->json(['user' => $user]);

// Redirect
return redirect('/dashboard');

// Error response
return Response::error('Validation failed', ['email' => 'Email is required']);
```
# Error Handling
## Route Not Found

When no route matches, a RouteNotFoundException is thrown.
Custom Error Handling
```php

try {
    // Route processing
} catch (RouteNotFoundException $e) {
    return response()->json(['error' => 'Not Found'], 404);
} catch (Exception $e) {
    return response()->json(['error' => $e->getMessage()], 500);
}
```
# API Routes
Example API Route
```php

Route::get('/api', function () {
    $user = ['name' => 'eric'];
    return response()->json(['user' => $user]);
});
```
# API Response Formats
```php

// JSON
return response()->json($data);

// XML
return response()->xml($data);

// Stream JSON
return stream_json($largeDataset);
```
# Best Practices

    Organize routes logically - Group related routes together

    Use controller methods - Prefer controllers over closures for complex logic

    Validate route parameters - Always validate incoming parameters

    Use middleware - Apply middleware for cross-cutting concerns

    Document routes - Add comments explaining route purpose

    Version API routes - Prefix API routes with version (e.g., api/v1/)

# Complete Example
## web.php
```php

<?php declare(strict_types=1);

use Careminate\Routing\Route;
use App\Http\Controllers\{
    HomeController,
    UserController,
    PostController
};

// Home routes
Route::get('/', HomeController::class, 'index');
Route::get('/about', HomeController::class, 'about');

// User routes
Route::get('/users', UserController::class, 'index');
Route::get('/users/{id}', UserController::class, 'show');

// Post routes with middleware
Route::get('/posts', PostController::class, 'index', ['auth']);
Route::post('/posts', PostController::class, 'store', ['auth', 'admin']);
```
## api.php
```php

<?php declare(strict_types=1);

use Careminate\Routing\Route;
use App\Http\Controllers\Api\{
UserApiController,PostApiController};

// API v1 routes
Route::get('/api/users', UserApiController::class, 'index');
Route::get('/api/users/{id}', UserApiController::class, 'show');

Route::get('/api/posts', PostApiController::class, 'index');
Route::post('/api/posts', PostApiController::class, 'store');

 
```
This documentation covers the essential aspects of routing in the Careminate Framework. The system is designed to be intuitive while providing powerful features for building modern web applications and APIs.
New chat