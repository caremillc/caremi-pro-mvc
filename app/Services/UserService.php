<?php declare (strict_types = 1);
namespace App\Services;

use Careminate\Logs\LoggerInterface;

class UserService
{
    public function __construct(protected LoggerInterface $logger) {}

    public function createUser(string $name)
    {
        $this->logger->log("User {$name} created.");
    }
}
