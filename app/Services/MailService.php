<?php declare (strict_types = 1);
namespace App\Services;

use Careminate\Logs\Log;
use Careminate\Attributes\Inject;

class MailService
{
    public function __construct(#[Inject(Log::class)] protected Log $logger) {}

    public function sendMail($to, $msg)
    {
        $this->logger->log("Sending mail to $to");
    }
}