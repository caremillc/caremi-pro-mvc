<?php declare(strict_types=1);

namespace App\Providers;

use Careminate\Logs\FileLogger;
use Careminate\Providers\ServiceProvider;
use Careminate\Logs\Contracts\LoggerInterface;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(LoggerInterface::class, FileLogger::class);

        $this->app->when(\App\Services\MailService::class)
                  ->needs(LoggerInterface::class)
                  ->give(function () {
                      return new \Careminate\Logs\Log('Used in report');
                  });
    }

    public function boot(): void
    {
        // Optionally perform bootstrapping
    }
}
