<?php


namespace App\Services;


use App\Services\StatusMessages\StatusMessageService;

class CustomService
{
    protected function fireStatusMessage(string $type, string $message): void
    {
        StatusMessageService::fireMessage($type, $message);
    }
}
