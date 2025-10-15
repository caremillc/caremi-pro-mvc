# Str Class Documentation

The `Str` class provides a collection of static methods for string manipulation, formatting, and analysis. It is part of the `Careminate\Support` namespace.

---

## Table of Contents

1. [Conversion Methods](#conversion-methods)
2. [Case Manipulation](#case-manipulation)
3. [String Analysis](#string-analysis)
4. [Substring Utilities](#substring-utilities)
5. [Random and Unique](#random-and-unique)
6. [Slug Utilities](#slug-utilities)
7. [Examples](#examples)

---

## Conversion Methods

### `camel(string $value): string`

Converts a string to **camelCase**.

**Example:**
```php
Str::camel('hello_world'); // helloWorld
Str::camel('my-function-name'); // myFunctionName
```
---
## snake(string $value, string $delimiter = '_'): string

Converts a string to snake_case.

**Example:**
```php
Str::snake('HelloWorld'); // hello_world
Str::snake('MyFunctionName'); // my_function_name
```
---

## kebab(string $value): string

Converts a string to kebab-case (URL-friendly, hyphenated).

**Example:**
```php
Str::kebab('HelloWorld'); // hello-world
```
---

## title(string $value): string

Converts a string to Title Case.


**Example:**
```php
Str::title('hello_world'); // Hello World
Str::title('my-function-name'); // My Function Name

```
---

## Case Manipulation
lower(string $value): string

Converts a string to lowercase.


**Example:**
```php
Str::lower('HELLO'); // hello
```
---

## upper(string $value): string

Converts a string to uppercase.


**Example:**
```php
Str::upper('hello'); // HELLO
```
---

## String Analysis
contains(string $haystack, string|array $needles): bool

Checks if the string contains one or more substrings.

**Example:**
```php
Str::contains('Hello World', 'Hello'); // true
Str::contains('Hello World', ['Foo', 'World']); // true
```
---

## startsWith(string $haystack, string|array $needles): bool

Checks if the string starts with a substring or any substring in an array.
**Example:**
```php
Str::startsWith('Hello World', 'Hello'); // true
Str::startsWith('Hello World', ['Foo', 'Hello']); // true

```
---

## endsWith(string $haystack, string|array $needles): bool

Checks if the string ends with a substring or any substring in an array.

**Example:**
```php
Str::endsWith('Hello World', 'World'); // true
Str::endsWith('Hello World', ['World', 'Foo']); // true

```
---

## Substring Utilities
after(string $subject, string $search): string

Returns the substring after the first occurrence of the search string.

**Example:**
```php
Str::after('Hello World', 'Hello '); // World

```
---

## before(string $subject, string $search): string

Returns the substring before the first occurrence of the search string.

**Example:**
```php
Str::before('Hello World', ' World'); // Hello

```
---
## limit(string $value, int $limit = 100, string $end = '...'): string

Truncates a string to a specified length and appends ... (or custom ending) if exceeded.

**Example:**
```php
Str::limit('Hello World', 5); // Hello...
Str::limit('Short', 10); // Short

```
---
## Random and Unique
random(int $length = 16): string

Generates a random string of specified length.

**Example:**
```php
Str::random(8); // e.g., "a1b2c3d4"

```
---

## Slug Utilities
slug(string $title, string $separator = '-'): string

Converts a string into a URL-friendly slug (lowercase, separator used for spaces).

**Example:**
```php
Str::slug('Hello World'); // hello-world
Str::slug('My Function Name', '_'); // my_function_name

```
---

## slugify(string $text, array $opts = []): string

Advanced slug generator with options:

separator (string): Default -

limit (int|null): Max length

lowercase (bool): Default true

transliterate (bool): Convert non-ASCII to ASCII

ascii (bool): Keep only ASCII (default true)

locale (string|null): Locale for lowercasing

**Example:**
```php
Str::slugify('Héllo Wørld!', ['separator' => '_']); // hello_world
Str::slugify('こんにちは世界', ['transliterate' => false]); // こんにちは世界

```
---
## Str signatures
**Example:**
```php
use Careminate\Support\Str;

echo Str::camel('my_function'); // myFunction
echo Str::snake('MyFunction'); // my_function
echo Str::kebab('MyFunction'); // my-function
echo Str::title('my_function'); // My Function
echo Str::lower('HELLO'); // hello
echo Str::upper('hello'); // HELLO
echo Str::contains('Hello World', 'World'); // true
echo Str::startsWith('Hello World', 'Hello'); // true
echo Str::endsWith('Hello World', 'World'); // true
echo Str::after('Hello World', 'Hello '); // World
echo Str::before('Hello World', ' World'); // Hello
echo Str::limit('This is a very long string', 10); // This is a...
echo Str::random(8); // Random 8-character string
echo Str::slug('My Function Name'); // my-function-name
echo Str::slugify('Héllo Wørld!'); // hello-world

```
---
## Namespace: Careminate\Support
Class: Str
PHP Version: 8.1+