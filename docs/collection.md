# Collection Class Documentation

The `Collection` class is a **powerful, fluent wrapper for arrays** in the Careminate framework.  
It provides **array manipulation, iteration, transformation, and aggregation** methods in a modern, object-oriented style.

---

## Namespace

```php
namespace Careminate\Support;
```
---

## Class: Collection
Overview

Collection wraps arrays and allows:

Fluent array transformations (map, filter, pluck, collapse, etc.)

Aggregations (sum, avg, min, max, median)

Sorting, grouping, and unique filtering

Dot notation access with get, set, has, and forget

Macros via Macroable trait

Implements ArrayAccess, IteratorAggregate, and Countable interfaces

**Example Usage:**
```php
use Careminate\Support\Collection;

$collection = Collection::make([1, 2, 3, 4]);

$sum = $collection->sum(); // 10

$even = $collection->filter(fn($v) => $v % 2 === 0);

$grouped = Collection::make([
    ['name' => 'Alice', 'role' => 'admin'],
    ['name' => 'Bob', 'role' => 'user'],
])->groupBy('role');
```
---

## Properties
protected array $items = []

Stores the collection items internally.

Accessible via collection methods, not directly.

## Methods
Constructor & Factory
public function __construct(array $items = [])

Initializes a new collection with the given items.

public static function make(array $items = []): static

Factory method to create a new collection instance.
```php 
$collection = Collection::make([1, 2, 3]);
```
---
## Array & Iteration Methods
| Method                        | Description                        |
| ----------------------------- | ---------------------------------- |
| `all(): array`                | Returns the internal items array.  |
| `getIterator(): Traversable`  | Returns a generator for iteration. |
| `count(): int`                | Returns the number of items.       |
| `offsetExists($offset): bool` | ArrayAccess support.               |
| `offsetGet($offset)`          | ArrayAccess support.               |
| `offsetSet($offset, $value)`  | ArrayAccess support.               |
| `offsetUnset($offset)`        | ArrayAccess support.               |

## Element Access
| Method                                               | Description                                                |
| ---------------------------------------------------- | ---------------------------------------------------------- |
| `first(?callable $callback = null, $default = null)` | Returns first item matching optional callback, or default. |
| `last(?callable $callback = null, $default = null)`  | Returns last item matching optional callback, or default.  |
| `get($key, $default = null)`                         | Dot notation get from items.                               |
| `set($key, $value): static`                          | Dot notation set in items.                                 |
| `has($key): bool`                                    | Checks if key exists.                                      |
| `forget($key): static`                               | Removes key from items.                                    |
| `pull($key, $default = null)`                        | Gets value and removes it from items.                      |
| `push($value): static`                               | Appends item to collection.                                |

## Transformation Methods
| Method                                       | Description                                           |                                              |                          |
| -------------------------------------------- | ----------------------------------------------------- | -------------------------------------------- | ------------------------ |
| `map(callable $callback): static`            | Applies callback to each item.                        |                                              |                          |
| `filter(?callable $callback = null): static` | Filters items using callback or truthiness.           |                                              |                          |
| `flatten(int $depth = PHP_INT_MAX): static`  | Flattens nested arrays to given depth.                |                                              |                          |
| `collapse(): static`                         | Merges sub-arrays into a single array.                |                                              |                          |
| `shuffle(): static`                          | Randomly shuffles items.                              |                                              |                          |
| `random(int $amount = 1)`                    | Returns random item(s).                               |                                              |                          |
| `pluck(string                                | callable $key, bool $slugKeys = false): static`       | Extracts values by key or callback.          |                          |
| `groupBy(string                              | callable $key, bool $slugKeys = false): static`       | Groups items by key or callback.             |                          |
| `keyBy(string                                | callable $key, bool $slugKeys = false): static`       | Keys collection items by key or callback.    |                          |
| `where(callable $callback): static`          | Filters collection using a callback.                  |                                              |                          |
| `tap(callable $callback): static`            | Runs callback and returns collection for chaining.    |                                              |                          |
| `pipe(callable $callback)`                   | Passes collection to callback and returns its result. |                                              |                          |
| `reverse(): static`                          | Reverses item order.                                  |                                              |                          |
| `unique(callable                             | string                                                | null $key = null): static`                   | Removes duplicate items. |
| `sortBy(callable                             | string $key, bool $ascending = true): static`         | Sorts items by key or callback (ascending).  |                          |
| `sortByDesc(callable                         | string $key): static`                                 | Sorts items by key or callback (descending). |                          |

## Aggregation Methods
| Method         | Description |                           |                            |                        |
| -------------- | ----------- | ------------------------- | -------------------------- | ---------------------- |
| `sum(string    | callable    | null $key = null): float  | int`                       | Returns sum of values. |
| `avg(string    | callable    | null $key = null): float` | Returns average of values. |                        |
| `min(string    | callable    | null $key = null)`        | Returns minimum value.     |                        |
| `max(string    | callable    | null $key = null)`        | Returns maximum value.     |                        |
| `median(string | callable    | null $key = null)`        | Returns median value.      |                        |

## Utility Methods
| Method                           | Description                                |
| -------------------------------- | ------------------------------------------ |
| `isEmpty(): bool`                | Returns true if collection has no items.   |
| `toJson(int $flags = 0): string` | Returns JSON representation of collection. |

## Macroable Support

The Collection class uses the Macroable trait, allowing custom methods to be added at runtime:
```php 
Collection::macro('double', function() {
    return $this->map(fn($v) => $v * 2);
});

$collection = Collection::make([1, 2, 3]);
$doubled = $collection->double(); // [2, 4, 6]

```
---

**Example Workflow**
```php 
$users = Collection::make([
    ['name' => 'Alice', 'role' => 'admin', 'age' => 25],
    ['name' => 'Bob', 'role' => 'user', 'age' => 30],
    ['name' => 'Charlie', 'role' => 'admin', 'age' => 35],
]);

// Filter admins
$admins = $users->where(fn($u) => $u['role'] === 'admin');

// Pluck names
$names = $users->pluck('name');

// Sum ages
$totalAge = $users->sum('age');

// Group by role
$grouped = $users->groupBy('role');

```
---

## Notes

Implements ArrayAccess, IteratorAggregate, Countable for array-like behavior.

Provides fluent, chainable methods for transforming arrays.

Fully compatible with PHP 8.1+ type system.

Macros allow developers to extend collection functionality at runtime.

## Namespace: Careminate\Support
Class: Collection
PHP Version: 8.1+
