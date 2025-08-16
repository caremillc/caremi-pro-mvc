# Request Component Documentation

The Request class in the Careminate framework encapsulates the incoming HTTP request and provides an easy API to access query parameters, post variables, headers, cookies, uploaded files, and server data.

# Overview

The Careminate\Http\Requests\Request class is responsible for:

Creating a request instance from PHP globals ($_GET, $_POST, $_FILES, $_COOKIE, $_SERVER).

Providing helper methods for retrieving input in a consistent manner.

Supporting JSON bodies and method spoofing (_method or X‑HTTP‑Method‑Override).

# Bootstrapping Flow

public/index.php defines constants and loads Composer autoloader.

It loads /bootstrap/app.php to register service providers.

It loads /bootstrap/performance.php to output performance data.

Finally, it creates a Request from globals and continues execution.

# Request Lifecycle

Request::createFromGlobals() gathers input from $_GET, $_POST, $_FILES, $_COOKIE, and $_SERVER.

It also parses JSON bodies and provides helper methods like get(), input(), query() and header manipulation methods.

FormRequest extends Request and performs validation and authorization automatically.


# Support Functions

dd() is an enhanced dump function with browser/CLI support.

helpers.php provides a value() helper to resolve closures.

Str and Arr contain utility methods for string and array manipulation.

# Validation

The Validate class accepts an array of $data, $rules, and optional $messages. It supports many built-in validation rules such as:

```bash 
required, string, email, min, max, integer, boolean,
array, in, not_in, same, different, date, url, regex, file, image

```

Validation Example
```php 
$data = ['email' => 'admin@example.com'];
$rules = ['email' => 'required|email'];
$validator = new Validate($data, $rules);

if ($validator->passes()) {
    // Validated
}

```

# UploadedFile Example
```php 
$file = new UploadedFile($_FILES['profile']);
if ($file->isValid() && $file->isImage()) {
    $file->store('storage/uploads');
}
```


Purpose: Handle file uploads with validation and storage capabilities.

```php

// Get file info
$file->getClientOriginalName(); // "example.jpg"
$file->getClientMimeType(); // "image/jpeg"
$file->getSize(); // 1024 (bytes)
$file->getExtension(); // "jpg"

// Validation
$file->isValid(); // true/false
$file->isImage(); // true for image/*
$file->isMime(['image/jpeg', 'image/png']); // Check specific types
$file->hasExtension(['jpg', 'png']); // Check file extensions

// Storage
$file->move('/path/to/dir'); // Returns bool
$file->store('uploads'); // Returns stored path or null
$file->storeAs('docs', 'report.pdf'); // Custom filename
```

# Bootstrapping Example
```php 
require_once BASE_PATH . '/vendor/autoload.php';
require_once BASE_PATH . '/bootstrap/app.php';
require_once BASE_PATH . '/bootstrap/performance.php';

$request = Request::createFromGlobals();
dd($request);
```


# Request Class
## Creating a Request
```php
use Careminate\Http\Requests\Request;

$request = Request::createFromGlobals();
```


Purpose: HTTP request handling with input data access.

```php

// Get request data
$name = $request->input('name');
$email = $request->get('email');
$all = $request->all();

// Check request type
if ($request->isPost()) {
    // Handle POST
}

// File handling
if ($request->hasFile('document')) {
    $file = $request->file('document');
}

// Headers
$token = $request->header('X-Auth-Token');
```


## Common Methods

## Method

Description
```bash
getMethod()
```
Returns the HTTP method (with spoofing support)
```bash
getUri()
```
Returns raw URI of the request
```bash
getPathInfo()
```
Returns the path without query string (e.g. /users)
```bash
fullUrl()
```
Returns full URL with scheme + host + URI
```bash
header($name)
```
Get single header
```bash
headers()
```
Returns all request headers as key => value array
```bash
get($key, $default)
```
Returns value from query, post or raw input
```bash
input($key, $default)
```
Returns post + raw body parameter
```bash
query($key, $default)
```
Returns query string parameter
```bash
post($key, $default)
```
Returns post parameter only
```bash
cookie($key, $default)
```
Returns cookie
```bash
only([...$keys])
```
Returns array with only the specified keys

except([...$keys])

Returns array without the specified keys

# JSON Support

createFromGlobals() will parse JSON request bodies (e.g. application/json) and populate the values into $inputParams.
```php
if ($request->isJson()) {
    $payload = $request->input('title');
}
```
# File Handling

Request exposes basic file access methods, but you usually want to use the FileRequest or UploadedFile class for full functionality.
```php
if ($request->hasFile('avatar')) {
    $info = $request->file('avatar');
}
```
# Method Spoofing

If the request is POST, you can spoof the intended method by passing:

<form method="POST">
    <input type="hidden" name="_method" value="PUT">
</form>

or header:

X‑HTTP‑Method‑Override: PATCH

The getMethod() helper will automatically return PUT or PATCH accordingly.

# Example Usage

Reading Basic Inputs
```php
if ($request->isPost()) {
    $email = $request->input('email');
    $remember = $request->input('remember', false);
}
```
# Working With Query Only
```php
$page = $request->query('page', 1);
```
# Retrieving All Input
```php
$all = $request->all();
```
# Filtering Keys
```php
$filtered = $request->only(['email', 'name']);
$without = $request->except(['token']);
```
# Extending Request

You can extend the Request class to add custom helpers tailored to your application needs:
```php
class CustomRequest extends Request
{
    public function isAjax(): bool
    {
        return strtolower($this->header('X-Requested-With')) === 'xmlhttprequest';
    }
}
```

# FormRequest Example
```php 
class UserRegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}

$request = new UserRegisterRequest();
$validated = $request->validated();

```
# FormRequest & Validation

Purpose: Form validation with rules and messages.

```php

// In controller
public function store(StoreUserRequest $request)
{
    // Only reaches here if validation passes
    $validated = $request->validated();
    
    // Create user with $validated data
}

// Example validation rules (in StoreUserRequest)
public function rules(): array
{
    return [
        'name' => 'required|string|min:3',
        'email' => 'required|email|unique:users',
        'password' => 'required|confirmed|min:8'
    ];
}
```


# Use Cases

## Normal HTTP Request
```php 
$request = Request::createFromGlobals();
if ($request->isPost()) {
    $data = $request->only(['email', 'password']);
}
```

# File Upload
```php 
if (FileRequest::hasFile('avatar')) {
    $stored = FileRequest::store('avatar', 'uploads');
}
```

# Validation in Controller
```php 
$validator = new Validate($request->all(), [
    'email' => 'required|email',
    'age'   => 'required|integer'
]);

if ($validator->fails()) {
    return $validator->errors();
}

```
# Complete Controller Example

## UserController.php:
```php
public function updateProfile(Request $request)
{
    // Validate
    if (!FileRequest::hasFile('avatar')) {
        return Response::badRequest('Avatar required');
    }

    $file = FileRequest::file('avatar');
    
    if (!$file->isImage()) {
        return Response::badRequest('Only images allowed');
    }

    // Store file
    $path = $file->store('uploads/avatars');
    
    // Update user
    $user->update([
        'avatar' => $path,
        'name' => $request->input('name')
    ]);

    return Response::json([
        'success' => true,
        'avatar' => $path
    ]);
}
```


# String & Array Helpers

Purpose: String/array manipulation utilities.

```php

// String manipulation
Str::camel('foo_bar'); // "fooBar"
Str::slug('Hello World'); // "hello-world"
Str::random(32); // Random string

// Array access
Arr::get($array, 'user.address.street');
Arr::only($data, ['name', 'email']);
Arr::has($config, 'database.connections.mysql');
```

# Debug Output
```php 
dd($request);
```

# Key Features Demonstrated:

    File Uploads - Validation, MIME checking, secure storage

    Form Validation - Rules, custom messages, automatic handling

    Request Handling - Input access, method checking, headers

    Response Generation - Various content types, status codes

    Utilities - String/array manipulation for common tasks

This system provides a comprehensive foundation for handling typical web application requirements with proper separation of concerns and type safety through strict typing.

# ✅ Summary

This gives you full Laravel-style FormRequest functionality in Careminate:
Feature	            Supported
Inheritance	           ✅
Authorization	       ✅
Rules	               ✅
Custom messages	       ✅
Auto-validation	       ✅
Error access	       ✅

# Summary

The Request component gives you a clean, consistent and testable way to access all parts of the HTTP request. It is the starting point for your Controllers and can be further extended with FormRequest for validation and authorization.

This setup provides a clean bootstrap process and a modular, extendable foundation for your Careminate framework. You can now build routing, controllers and service providers on top of this base.