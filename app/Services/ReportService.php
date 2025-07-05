<?php 
namespace App\Services;

use Careminate\Logs\Log;

class ReportService
{
    public function __construct(Log $logger) {
        $logger->log("ReportService initialized.");
    }
}