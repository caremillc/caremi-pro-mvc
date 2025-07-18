<?php declare(strict_types=1);

use Careminate\Logs\FileLogger;
use Careminate\Container\Container;
use Careminate\Logs\DailyFileLogger;
use Careminate\Logs\Contracts\LoggerInterface;

$container = new Container();

//daily log
$container->bind(LoggerInterface::class, function () {
    $driver = config('log.channels.' . config('log.default') . '.driver', 'file');

    return match ($driver) {
        'daily' => new DailyFileLogger(),
        default => new FileLogger(),
    };
});

return $container;

