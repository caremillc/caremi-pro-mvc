# Careminate Support Utilities

Comprehensive documentation for the Careminate framework support classes and traits.

**Namespace:** `Careminate\Support`
**PHP Version:** 8.1+ recommended

---

## Table of Contents

* [Arr](#arr)
* [Str](#str)
* [Macroable](#macroable)
* [Config](#config)
* [Collection](#collection)

---

## Arr

* Goto [Arr Class](./arr.md)

**Class:** `Arr`
**Purpose:** Array utilities for manipulation, retrieval, and inspection.

### Methods

#### `add(array $array, string|int $key, mixed $value): array`

Add a value to the array if it does not already exist at the given key.

```php
Arr::add(['user' => ['name' => 'John']], 'user.age', 30);
```

#### `only(array $array, array|string $keys): array`

Return only the specified keys from the array.

```php
Arr::only(['name' => 'John', 'age' => 30], ['name']); // ['name' => 'John']
```

#### `exists(array|ArrayAccess $array, string|int $key): bool`

Check if a key exists in an array or ArrayAccess object.

#### `get(array|ArrayAccess $array, string|int|null $key, mixed $default = null): mixed`

Retrieve a value using dot notation, with optional default.

#### `set(array &$array, string|int $key, mixed $value): void`

Set a value in the array using dot notation.

#### `has(array $array, string|int $key): bool`

Check if a key exists using dot notation.

#### `forget(array &$array, string|int $key): void`

Remove an item using dot notation.

#### `first(array $array, ?callable $callback = null, mixed $default = null): mixed`

Return the first element, optionally filtered by callback.

#### `last(array $array, ?callable $callback = null, mixed $default = null): mixed`

Return the last element, optionally filtered by callback.

#### `flatten(array $array, int $depth = PHP_INT_MAX): array`

Flatten a multi-dimensional array.

#### `pluck(array $array, string $value, ?string $key = null): array`

Retrieve a list of values from an array of arrays or objects.

#### `map(array $array, callable $callback): array`

Map a callback over the array.

#### `where(array $array, callable $callback): array`

Filter the array using a callback.

#### `random(array $array, int $number = 1): mixed`

Get one or more random elements.

#### `shuffle(array $array): array`

Shuffle the array values.

#### `collapse(array $array): array`

Collapse an array of arrays into a single array.

#### `pull(array &$array, string|int $key, mixed $default = null): mixed`

Retrieve a value and remove it from the array.

#### `wrap(mixed $value): array`

Ensure the value is returned as an array.

#### `accessible(mixed $value): bool`

Check if a value is array-accessible.

#### `except(array $array, array|string $keys): array`

Return all items except specified keys.

---
* Goto [Arr Class](./arr.md)
 


## Str

* Goto [Str Class](./str.md)

**Class:** `Str`
**Purpose:** String utilities for case conversion, manipulation, and formatting.

### Methods

* `camel(string $value): string` – Convert to camelCase
* `snake(string $value, string $delimiter = '_'): string` – Convert to snake_case
* `kebab(string $value): string` – Convert to kebab-case
* `title(string $value): string` – Convert to Title Case
* `lower(string $value): string` – Convert to lowercase
* `upper(string $value): string` – Convert to uppercase
* `limit(string $value, int $limit = 100, string $end = '...'): string` – Truncate string
* `contains(string $haystack, string|array $needles): bool` – Check if string contains
* `startsWith(string $haystack, string|array $needles): bool` – Check if string starts with
* `endsWith(string $haystack, string|array $needles): bool` – Check if string ends with
* `after(string $subject, string $search): string` – Substring after search
* `before(string $subject, string $search): string` – Substring before search
* `random(int $length = 16): string` – Generate random string
* `slug(string $title, string $separator = '-'): string` – Create URL slug
* `slugify(string $text, array $opts = []): string` – Advanced slug creation

---

## Macroable
* Goto [Macroable Class](./macroable.md)
**Trait:** `Macroable`
**Purpose:** Add dynamic macro methods to classes.

### Methods

* `macro(string $name, callable $macro): void` – Register a macro
* `hasMacro(string $name): bool` – Check if macro exists
* `__call(string $method, array $parameters)` – Invoke dynamic instance macro
* `__callStatic(string $method, array $parameters)` – Invoke dynamic static macro

**Example:**

```php
class Example {
    use Macroable;
}

Example::macro('greet', fn($name) => "Hello, $name!");
echo Example::greet('John'); // "Hello, John!"
```

---

## Config

* Goto [Config Class](./config.md)

**Class:** `Config`
**Purpose:** Manage configuration files with caching and dot notation access.

### Methods

* `get(string $key, mixed $default = null): mixed` – Get configuration value
* `has(string $key): bool` – Check if configuration key exists
* `set(string $key, mixed $value): void` – Set a configuration value

**Internal helpers:**

* `getFileFromKey(string $key): string` – Extract file name from key
* `getNestedKey(string $key): ?string` – Extract nested key path

**Example:**

```php
Config::set('app.name', 'Careminate');
$name = Config::get('app.name'); // 'Careminate'
```

---

## Collection

* Goto [Collection Class](./collection.md)

**Class:** `Collection`
**Purpose:** Object-oriented wrapper for arrays with advanced utilities.

### Features

* Implements `ArrayAccess`, `Countable`, `IteratorAggregate`
* Uses `Macroable` for dynamic methods

### Methods

* `make(array $items = []): static` – Create a new collection
* `all(): array` – Get all items
* `map(callable $callback): static` – Map items
* `filter(?callable $callback = null): static` – Filter items
* `first(?callable $callback = null, mixed $default = null): mixed`
* `last(?callable $callback = null, mixed $default = null): mixed`
* `flatten(int $depth = PHP_INT_MAX): static`
* `sum(string|callable|null $key = null): float|int`
* `avg(string|callable|null $key = null): float`
* `max(string|callable|null $key = null): mixed`
* `min(string|callable|null $key = null): mixed`
* `median(callable|string|null $key = null): mixed`
* `groupBy(string|callable $key, bool $slugKeys = false): static`
* `keyBy(string|callable $key, bool $slugKeys = false): static`
* `sortBy(callable|string $key, bool $ascending = true): static`
* `sortByDesc(callable|string $key): static`
* `unique(callable|string|null $key = null): static`
* `reverse(): static`
* `pluck(string|callable $key, bool $slugKeys = false): static`
* `get(string|int|null $key, mixed $default = null): mixed`
* `set(string|int $key, mixed $value): static`
* `has(string|int $key): bool`
* `forget(string|int $key): static`
* `where(callable $callback): static`
* `shuffle(): static`
* `random(int $amount = 1): mixed`
* `collapse(): static`
* `pull(string|int $key, mixed $default = null): mixed`
* `push(mixed $value): static`
* `tap(callable $callback): static`
* `pipe(callable $callback): mixed`
* `isEmpty(): bool`
* `toJson(int $flags = 0): string`

**Example:**

```php
$collection = Collection::make([1,2,3,4])
    ->filter(fn($v) => $v > 2)
    ->map(fn($v) => $v * 2);

$sum = $collection->sum(); // 14
```

---

## public/index.php
```php
<?php declare (strict_types = 1);

use Careminate\Support\Arr;
use Careminate\Support\Collection;
use Careminate\Support\Config;
use Careminate\Support\Str;

// ---------------------------------------------------------
// Bootstrap the framework
// ---------------------------------------------------------
require __DIR__ . '/../bootstrap/app.php';

echo "==============================\n";
echo "Careminate Framework Test\n";
echo "==============================\n\n";

// ------------------------------
// 1. Testing Arr Utility
// ------------------------------
$array = [
    'user' => [
        'name'  => 'John Doe',
        'email' => 'john@example.com',
        'roles' => ['admin', 'editor'],
    ],
];

echo"<pre>";
echo "Arr::get: " . Arr::get($array, 'user.name') . "\n"; // John Doe
Arr::set($array, 'user.age', 30);
echo "Arr::get after set: " . Arr::get($array, 'user.age') . "\n"; // 30
Arr::forget($array, 'user.email');
echo "Arr::has email: " . (Arr::has($array, 'user.email') ? 'Yes' : 'No') . "\n"; // No

die();
// ------------------------------
// 2. Testing Str Utility
// ------------------------------
echo "\nStr::camel: " . Str::camel('hello_world') . "\n";       // helloWorld
echo "Str::snake: " . Str::snake('HelloWorld') . "\n";          // hello_world
echo "Str::kebab: " . Str::kebab('HelloWorld') . "\n";          // hello-world
echo "Str::slugify: " . Str::slugify('This is a test!') . "\n"; // this-is-a-test
echo "Str::random: " . Str::random(8) . "\n";

// ------------------------------
// 3. Testing Collection
// ------------------------------
$collection = new Collection([
    ['name' => 'Alice', 'age' => 25],
    ['name' => 'Bob', 'age' => 30],
    ['name' => 'Charlie', 'age' => 25],
]);

echo "\nCollection::pluck names:\n";
print_r($collection->pluck('name')->toJson());

echo "Collection::groupBy age:\n";
print_r($collection->groupBy('age')->toJson());

echo "Collection::sum age: " . $collection->sum('age') . "\n";
echo "Collection::avg age: " . $collection->avg('age') . "\n";

// ------------------------------
// 4. Testing Config
// ------------------------------
// Ensure config/app.php exists with 'name' => 'Careminate'
Config::set('app.debug', true);
echo "\nConfig::get app.name: " . Config::get('app.name', 'DefaultApp') . "\n";
echo "Config::get app.debug: " . (Config::get('app.debug') ? 'true' : 'false') . "\n";
echo "Config::has app.env: " . (Config::has('app.env') ? 'Yes' : 'No') . "\n";

// ------------------------------
// 5. Testing Macroable
// ------------------------------
Collection::macro('doubleAges', function () {
    return $this->map(fn($item) => ['name' => $item['name'], 'age' => $item['age'] * 2]);
});

$doubled = $collection->doubleAges();
echo "\nCollection::doubleAges:\n";
print_r($doubled->toJson());

echo "\n==============================\n";
echo "Tests Completed!\n";
echo "==============================\n";
?>
```

**End of Careminate Support Utilities Documentation**

