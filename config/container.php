<?php declare(strict_types=1);

use Careminate\Logs\FileLogger;
use Careminate\Container\Container;
use Careminate\Logs\DailyFileLogger;
use Careminate\Logs\Contracts\LoggerInterface;

$container = new Container();

// Load environment variables
$dotenv = new \Symfony\Component\Dotenv\Dotenv();
$dotenv->load(dirname(__DIR__) . '/.env');

#env parameters
$appEnv = env('APP_ENV', 'production'); // Default to 'production' if not set
$appKey = env('APP_KEY'); // Default to 'production' if not set
$appVersion = env('APP_VERSION');

$container->add('APP_ENV', $appEnv);
$container->add('APP_KEY', $appKey);
$container->add('APP_VERSION', $appVersion);

# parameters for application config
$routes  = glob(BASE_PATH . '/routes/*.php');
// sort($routes);
foreach ($routes as $route) {
    // echo $route;
    require_once $route;
}

// Bind RouterInterface to Router implementation
$container->bind(\Careminate\Routing\Contracts\RouterInterface::class, \Careminate\Routing\Router::class);

// Bind routes to container
$container->extend(\Careminate\Routing\Contracts\RouterInterface::class)
    ->addMethodCall('setRoutes',[$routes]);

// Register the HTTP Kernel with its dependencies
$container->bind(\Careminate\Http\Kernel::class)
          ->addArgument(\Careminate\Routing\Contracts\RouterInterface::class);

$container->instance(\Careminate\Container\Contracts\ContainerInterface::class, $container);

$container->bind(\Careminate\Http\Kernel::class)
          ->addArguments([
              \Careminate\Routing\Contracts\RouterInterface::class,
              \Careminate\Container\Contracts\ContainerInterface::class,
          ]);

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



dd($container);
return $container;

