# Macroable Trait Documentation

The `Macroable` trait allows classes to **dynamically add methods** at runtime via macros (closures).  
It provides support for both **instance** and **static** macros.

---

## Namespace

```php
namespace Careminate\Support;
```
---

## Trait: Macroable
Overview

The Macroable trait enables the following functionality:

Add dynamic methods (macros) to a class.

Check if a macro exists.

Call macros as if they were regular methods.

Support static and instance method calls.

## use Careminate\Support\Macroable;
```php
class MyClass {
    use Macroable;
}

// Define an instance macro
MyClass::macro('greet', function($name) {
    return "Hello, $name!";
});

$instance = new MyClass();
echo $instance->greet('Willy'); // Hello, Willy!
```
---

## Properties
protected static array $macros = []

Holds all registered macros for the class.

Type: array

Access: protected

Format: [methodName => callable]

## Methods
public static function macro(string $name, callable $macro): void

Registers a new macro.

Parameters:
| Name     | Type     | Description                |
| -------- | -------- | -------------------------- |
| `$name`  | string   | Macro method name          |
| `$macro` | callable | Closure or callable method |

```php 
MyClass::macro('greet', function($name) {
    return "Hello, $name!";
});

```
---

## public static function hasMacro(string $name): bool

Checks if a macro is defined.

Parameters:
| Name    | Type   | Description       |
| ------- | ------ | ----------------- |
| `$name` | string | Macro method name |

## Returns: bool — true if macro exists, false otherwise.

**Example:**
```php 
if (MyClass::hasMacro('greet')) {
    echo "Macro exists!";
}
```

## public function __call(string $method, array $parameters)

Handles calls to undefined instance methods.
If a macro with that name exists, it executes the macro.

Parameters:
```php 
if (MyClass::hasMacro('greet')) {
    echo "Macro exists!";
}

```

## public function __call(string $method, array $parameters)

Handles calls to undefined instance methods.
If a macro with that name exists, it executes the macro.

Parameters:
| Name          | Type   | Description                |
| ------------- | ------ | -------------------------- |
| `$method`     | string | Method name being called   |
| `$parameters` | array  | Arguments passed to method |

## Returns: Mixed — result of the macro callable.

Throws: BadMethodCallException if macro does not exist.

```php 
$instance = new MyClass();
echo $instance->greet('Willy'); // Calls the macro 'greet'
```

## public static function __callStatic(string $method, array $parameters)

Handles calls to undefined static methods.
If a static macro with that name exists, it executes the macro.
Parameters:

| Name          | Type   | Description                     |
| ------------- | ------ | ------------------------------- |
| `$method`     | string | Static method name being called |
| `$parameters` | array  | Arguments passed to method      |

Returns: Mixed — result of the macro callable.

Throws: BadMethodCallException if macro does not exist.

Example:
```php 
echo MyClass::greet('Willy'); // Calls the static macro 'greet'
```
---
## Example Usage
```php 
use Careminate\Support\Macroable;

class Example {
    use Macroable;
}

// Instance macro
Example::macro('sayHi', function($name) {
    return "Hi, $name!";
});

// Static macro
Example::macro('welcome', function($name) {
    return "Welcome, $name!";
});

$instance = new Example();
echo $instance->sayHi('Alice'); // Hi, Alice!
echo Example::welcome('Bob');    // Welcome, Bob!
```
## Notes

Macros are global per class, meaning all instances of the class share the same macros.

Macros can access $this when called on an instance, thanks to bindTo().

If a macro does not exist, a BadMethodCallException will be thrown.

Useful for extending framework classes without inheritance or modifying core code.

## Namespace: Careminate\Support
Trait: Macroable
PHP Version: 8.1+

--- 