# Arr.php Documentation

This documentation covers the **Arr.php** class from the Careminate framework, which provides a suite of powerful and modern array manipulation utilities.

---

## Namespace

```php
namespace Careminate\Support;
```

## Class Declaration

```php
class Arr
```

The `Arr` class contains static methods for array handling, including deep access, manipulation, and common functional programming utilities.

---

## Methods

### `add(array $array, string|int $key, mixed $value): array`

Adds a value to the array using "dot" notation if the key doesn't already exist.

**Example:**

```php
$array = ['user' => ['name' => 'John']];
$array = Arr::add($array, 'user.age', 30);
// Result: ['user' => ['name' => 'John', 'age' => 30]]
```

---

### `only(array $array, array|string $keys): array`

Returns only the specified keys from the array.

**Example:**

```php
$array = ['name' => 'John', 'age' => 30, 'city' => 'NYC'];
$result = Arr::only($array, ['name', 'city']);
// Result: ['name' => 'John', 'city' => 'NYC']
```

---

### `exists(array|ArrayAccess $array, string|int $key): bool`

Checks if the key exists in an array or an ArrayAccess object.

**Example:**

```php
$array = ['name' => 'John'];
Arr::exists($array, 'name'); // true
Arr::exists($array, 'age');  // false
```

---

### `get(array|ArrayAccess $array, string|int|null $key, mixed $default = null): mixed`

Retrieve an item from an array using "dot" notation. Returns `$default` if the key does not exist.

**Example:**

```php
$array = ['user' => ['name' => 'John']];
$name = Arr::get($array, 'user.name'); // 'John'
$age = Arr::get($array, 'user.age', 25); // 25
```

---

### `set(array &$array, string|int $key, mixed $value): void`

Sets a value in an array using "dot" notation.

**Example:**

```php
$array = ['user' => ['name' => 'John']];
Arr::set($array, 'user.age', 30);
// Result: ['user' => ['name' => 'John', 'age' => 30]]
```

---

### `has(array $array, string|int $key): bool`

Determines if a given key exists in the array using "dot" notation.

**Example:**

```php
$array = ['user' => ['name' => 'John']];
Arr::has($array, 'user.name'); // true
Arr::has($array, 'user.age');  // false
```

---

### `forget(array &$array, string|int $key): void`

Removes an item from an array using "dot" notation.

**Example:**

```php
$array = ['user' => ['name' => 'John', 'age' => 30]];
Arr::forget($array, 'user.age');
// Result: ['user' => ['name' => 'John']]
```

---

### `first(array $array, ?callable $callback = null, mixed $default = null): mixed`

Returns the first element of the array that passes the given callback, or the first element if no callback is provided.

**Example:**

```php
$array = [1, 2, 3];
Arr::first($array); // 1
Arr::first($array, fn($v) => $v > 1); // 2
```

---

### `last(array $array, ?callable $callback = null, mixed $default = null): mixed`

Returns the last element of the array that passes the given callback.

**Example:**

```php
$array = [1, 2, 3];
Arr::last($array); // 3
Arr::last($array, fn($v) => $v < 3); // 2
```

---

### `flatten(array $array, int $depth = PHP_INT_MAX): array`

Flattens a multi-dimensional array into a single-level array.

**Example:**

```php
$array = [1, [2, 3], [4, [5]]];
Arr::flatten($array); // [1, 2, 3, 4, 5]
```

---

### `pluck(array $array, string $value, ?string $key = null): array`

Extracts a list of values from a multi-dimensional array.

**Example:**

```php
$array = [['name' => 'John'], ['name' => 'Jane']];
Arr::pluck($array, 'name'); // ['John', 'Jane']
```

---

### `map(array $array, callable $callback): array`

Applies a callback to each item in the array and returns the results.

**Example:**

```php
$array = [1, 2, 3];
Arr::map($array, fn($v) => $v * 2); // [2, 4, 6]
```

---

### `where(array $array, callable $callback): array`

Filters an array using a callback function.

**Example:**

```php
$array = [1, 2, 3];
Arr::where($array, fn($v) => $v > 1); // [2, 3]
```

---

### `random(array $array, int $number = 1): mixed`

Returns one or more random elements from the array.

**Example:**

```php
$array = [1, 2, 3];
Arr::random($array);    // 1 element
Arr::random($array, 2); // array of 2 random elements
```

---

### `shuffle(array $array): array`

Shuffles the array randomly.

**Example:**

```php
$array = [1, 2, 3];
Arr::shuffle($array); // e.g. [3, 1, 2]
```

---

### `collapse(array $array): array`

Collapses an array of arrays into a single array.

**Example:**

```php
$array = [[1, 2], [3, 4]];
Arr::collapse($array); // [1, 2, 3, 4]
```

---

### `pull(array &$array, string|int $key, mixed $default = null): mixed`

Gets a value from the array and removes it.

**Example:**

```php
$array = ['name' => 'John', 'age' => 30];
$name = Arr::pull($array, 'name'); // 'John'
// $array = ['age' => 30]
```

---

### `wrap(mixed $value): array`

Wraps a value in an array if it is not already an array.

**Example:**

```php
Arr::wrap('John'); // ['John']
Arr::wrap(['John']); // ['John']
```

---

### `accessible(mixed $value): bool`

Determines if a value is array-accessible.

**Example:**

```php
Arr::accessible(['a']); // true
Arr::accessible('a');    // false
```

---

### `except(array $array, array|string $keys): array`

Returns all array elements except the specified keys.

**Example:**

```php
$array = ['name' => 'John', 'age' => 30];
Arr::except($array, 'age'); // ['name' => 'John']
```

---

This completes the documentation for **Arr.php**.
It provides a robust, modern, and production-ready API for array manipulation in Careminate.

