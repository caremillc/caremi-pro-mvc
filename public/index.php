<?php declare(strict_types=1);

use Careminate\Support\Arr;
use Careminate\Support\Str;
use Careminate\Support\Collection;
use Careminate\Support\Config;

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
        'name' => 'John Doe',
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

// ------------------------------
// 2. Testing Str Utility
// ------------------------------
echo "\nStr::camel: " . Str::camel('hello_world') . "\n"; // helloWorld
echo "Str::snake: " . Str::snake('HelloWorld') . "\n"; // hello_world
echo "Str::kebab: " . Str::kebab('HelloWorld') . "\n"; // hello-world
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
