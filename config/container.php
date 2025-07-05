<?php 

use App\Services\ReportService;
use Careminate\Logs\FileLogger;
use Careminate\Container\Container;
use Careminate\Logs\DailyFileLogger;
use Careminate\Logs\LoggerInterface;

$container = new Container();

$container->bind(LoggerInterface::class, \Careminate\Logs\FileLogger::class);

//daily log
$container->bind(LoggerInterface::class, function () {
    $driver = config('log.channels.' . config('log.default') . '.driver', 'file');

    return match ($driver) {
        'daily' => new DailyFileLogger(),
        default => new FileLogger(),
    };
});

// $container->when(ReportService::class)
//           ->needs(LoggerInterface::class)
//           ->give(function () {
//               return new \Careminate\Logs\Log("Used by ReportService");
//           });
          
return $container;