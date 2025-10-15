# Caremi Project 🚀

The skeleton application for the Caremi-pro framework.


Its use and look is very similar to the Laravel framework.

The initial purpose of Caremi was to create a PHP framework and then make a course out of it and teach developers all around the world, how to create a PHP framework from scratch.

You can learn how this framework was create step by step from [here](https://caremi.com).

- [Installation](#install)

--- 

# Careminate Framework - Request Documentation


# Careminate Framework – Request Guide

## Overview

The `Request` class in Careminate provides a **production-ready HTTP request abstraction**. It normalizes PHP superglobals (`$_GET`, `$_POST`, `$_SERVER`, `$_FILES`, `$_COOKIE`) into a structured object, making it easy to interact with request data, headers, and HTTP methods.

---

## Creating a Request

### 1. From Global Variables (Recommended)

```php
use Careminate\Http\Requests\Request;

$request = Request::createFromGlobals();
```

* Converts superglobals into a normalized object.
* Parses raw input (JSON or form-encoded).
* Handles HTTP method spoofing (`_method` parameter or `X-HTTP-Method-Override` header).

---

### 2. Manual Construction (Optional)

```php
$request = new Request(
    $_GET,
    $_POST,
    file_get_contents('php://input'), // raw body
    $_COOKIE,
    $_FILES,
    $_SERVER,
    $inputParams, // parsed JSON or raw input array
    file_get_contents('php://input') // raw string
);
```

---

## Accessing Request Data

### 1. Query Parameters (GET)

```php
$name = $request->query('name', 'default');
```

### 2. POST Parameters

```php
$email = $request->post('email');
```

### 3. Combined Input

```php
$all = $request->all(); // merges GET, POST, and JSON body
$value = $request->input('key', 'default');
```

### 4. Helpers

```php
$request->has('key');       // check if key exists
$request->only(['a','b']);  // get only specific keys
$request->except(['password']); // get all except some keys
```

---

## Raw Input

```php
$rawBody = $request->raw();       // raw body as string
$bodyParam = $request->input('param'); // parsed from JSON or form data
```

---

## Files

```php
$file = $request->file('avatar');
if ($request->hasFile('avatar')) {
    // process uploaded file
}
$allFiles = $request->allFiles(); // array of uploaded files
```

---

## Cookies

```php
$token = $request->cookie('session_token', null);
```

---

## Headers

```php
$userAgent = $request->header('User-Agent');
$accept = $request->header('Accept');
```

* Normalizes `$_SERVER` headers (e.g., `HTTP_ACCEPT` → `Accept`).

---

## HTTP Method & Spoofing

```php
$method = $request->getMethod(); // GET, POST, PUT, PATCH, DELETE
$request->isPost();   // true if POST
$request->isPut();    // true if PUT
$request->isAjax();   // true if XMLHttpRequest
```

* Spoofed methods supported via:

  * `_method` form field
  * `X-HTTP-Method-Override` header

---

## Path & URL

```php
$path = $request->getPathInfo(); // e.g., /users/123
$url  = $request->fullUrl();     // full URL with host, scheme, path
```

---

## User Info

```php
$ip = $request->ip();           // Client IP
$ua = $request->userAgent();    // User-Agent string
```

---

## JSON Requests

```php
if ($request->isJson()) {
    $data = $request->json();  // decode JSON body into array
}

if ($request->wantsJson()) {
    // Accept header includes application/json
}
```

---

## Validation

```php
$request->validate([
    'name' => 'required|string',
    'age'  => 'required|numeric|min:18',
    'email'=> 'required|email',
]);
```

* Throws a `RuntimeException` if validation fails.
* Use `$request->errors()` to get an array of validation errors.

---

## Old Input

```php
$oldName = $request->old('name'); // Previously submitted input
```

---

## Example Usage in a Controller

```php
public function store(Request $request) {
    // Validate request
    $request->validate([
        'username' => 'required|string',
        'email'    => 'required|email',
    ]);

    // Access input
    $username = $request->input('username');
    $email = $request->input('email');

    // Access headers
    $ua = $request->userAgent();

    // Return response
    return response()->json(['status' => 'ok']);
}
```

---

# request-quick-reference.md - Cheat Sheet

## Create Request

```php
$request = Request::createFromGlobals();
$request = new Request($_GET, $_POST, file_get_contents('php://input'), $_COOKIE, $_FILES, $_SERVER, $inputParams, file_get_contents('php://input'));
```

## Input / Query

```php
$request->all();
$request->input('key', $default);
$request->get('key', $default);
$request->query('key', $default);
$request->post('key', $default);
$request->only(['a','b']);
$request->except(['password']);
$request->has('key');
```

## Cookies

```php
$request->cookie('session_token', null);
```

## Files

```php
$request->file('avatar');
$request->hasFile('avatar');
$request->allFiles();
```

## Headers

```php
$request->header('User-Agent');
$request->headers();
$request->isAjax();
$request->wantsJson();
```

## HTTP Method & Spoofing

```php
$request->getMethod();
$request->isGet(); $request->isPost();
$request->isPut(); $request->isPatch(); $request->isDelete();
$request->isHead(); $request->isOptions();
```

## Path & URL

```php
$request->getPathInfo();
$request->fullUrl();
```

## User Info

```php
$request->ip();
$request->userAgent();
```

## Raw / JSON Body

```php
$request->raw();
$request->json();
$request->isJson();
```

## Validation

```php
$request->validate([...]);
$request->errors();
```

## Old Input

```php
$request->old('username');
```

## Example Usage

```php
if ($request->isPost() && $request->has('username')) {
    $username = $request->input('username');
    $email = $request->input('email');
    $ip = $request->ip();
}
```