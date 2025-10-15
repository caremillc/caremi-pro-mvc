# Config Class Documentation

The `Config` class provides a **centralized configuration management** system for your Careminate framework.  
It allows you to **load, get, set, and cache configuration values** from PHP configuration files.

---

## Namespace

```php
namespace Careminate\Support;
```
---
## Class: Config
Overview

The Config class allows developers to:

Access configuration values via dot notation.

Check if a configuration key exists.

Dynamically set configuration values at runtime.

Cache loaded configuration files for performance.

**Example Usage:**
```php 
use Careminate\Support\Config;

// Get a configuration value
$dbHost = Config::get('database.mysql.host', 'localhost');

// Set a runtime configuration value
Config::set('app.debug', true);

// Check if a configuration key exists
if (Config::has('app.debug')) {
    echo "Debug mode is set.";
}
```
---

## Properties
protected static array $cache = []

Stores loaded configuration files to avoid repeated file access.

Type: array

Format: [fileName => configArray]
```php 

```
---
## Methods
public static function get(string $key, mixed $default = null): mixed

Fetches a configuration value using dot notation.

Parameters:
| Name       | Type   | Description                                 |
| ---------- | ------ | ------------------------------------------- |
| `$key`     | string | The configuration key (e.g., `'app.debug'`) |
| `$default` | mixed  | Default value if key is not found           |

Returns: Mixed — the configuration value or the default.

Example:
```php 
$host = Config::get('database.mysql.host', '127.0.0.1');

```
---
## public static function has(string $key): bool

Checks if a configuration key exists.

Parameters:
| Name   | Type   | Description           |
| ------ | ------ | --------------------- |
| `$key` | string | The configuration key |

**Example:**
```php
if (Config::has('app.name')) {
    echo "App name is defined.";
}
```
---
## public static function set(string $key, mixed $value): void

Sets a configuration value at runtime.
Does not persist to the configuration file—it only updates the cached copy.

Parameters:
| Name     | Type   | Description                       |
| -------- | ------ | --------------------------------- |
| `$key`   | string | Configuration key in dot notation |
| `$value` | mixed  | Value to set                      |

**Example:** 
```php 
Config::set('app.timezone', 'UTC');
```
---
## Protected Methods
protected static function getFileFromKey(string $key): string

Extracts the configuration file name from a dot-notated key.

**Example:**
```php 
Config::getFileFromKey('database.mysql.host'); // Returns 'database'

```

---
## protected static function getNestedKey(string $key): ?string

Extracts the nested key (after the file name) from a dot-notated key.

**Example:**
```php 
Config::getNestedKey('database.mysql.host'); // Returns 'mysql.host'
Config::getNestedKey('app.name');            // Returns 'name'
Config::getNestedKey('app');                 // Returns null

```
---

## Features

Dot notation access: 'file.key.subkey'.

Lazy-loading: Only loads config file when first accessed.

Runtime caching: Prevents repeated file reads for performance.

Runtime setting: Can dynamically set values without touching files.

Safe defaults: Returns a default value if key/file does not exist.

**Example Workflow**
```php 
// Access config value
$timezone = Config::get('app.timezone', 'UTC');

// Update config value at runtime
Config::set('app.debug', true);

// Check if a key exists
if (Config::has('database.mysql.host')) {
    echo "Database host is set.";
}

// Nested keys with dot notation
$dbUser = Config::get('database.mysql.user', 'root');
```
---

## Notes

Configuration files are located in BASE_PATH . '/config/' and must return an associative array.

Cached values are stored in Config::$cache and persist only during the runtime.

Changing values via set() does not write to the actual file.

Ideal for centralized, runtime-safe configuration management.

## Namespace: Careminate\Support
Class: Config
PHP Version: 8.1+