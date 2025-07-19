<?php declare(strict_types=1);

use Careminate\Logs\FileLogger;
use Careminate\Container\Container;
use Careminate\Logs\DailyFileLogger;
use Careminate\Logs\Contracts\LoggerInterface;

$container = new Container();

// Bind RouterInterface to Router implementation
$container->bind(\Careminate\Routing\Contracts\RouterInterface::class, \Careminate\Routing\Router::class);

// Register the HTTP Kernel with its dependencies
$container->bind(\Careminate\Http\Kernel::class)
          ->addArgument(\Careminate\Routing\Contracts\RouterInterface::class);
//daily log
$container->bind(LoggerInterface::class, function () {
    $driver = config('log.channels.' . config('log.default') . '.driver', 'file');

    return match ($driver) {
        'daily' => new DailyFileLogger(),
        default => new FileLogger(),
    };
});

$container->registerProviders([
   App\Providers\AppServiceProvider::class, // ✅ Pass class name instead
]);



// dd($container);
return $container;

