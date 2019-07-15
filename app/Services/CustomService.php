<?php


namespace App\Services;


use App\Entities\StatusMessage;

class CustomService
{
    protected function fireStatusMessage(string $type, string $message): void
    {
        request()->session()->flash('status', new StatusMessage($type, $message));
    }
}
