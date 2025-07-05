<?php declare (strict_types = 1);

namespace App\Services;

use Careminate\Logs\LoggerInterface;

class AuthService
{
    public function __construct(protected LoggerInterface $logger) {}

    public function createUser(string $name)
    {
        $this->logger->log("AuthService created user: {$name}");
    }
}
