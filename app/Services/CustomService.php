<?php


namespace App\Services;


use App\Entities\StatusMessage;

class CustomService
{
    protected function fireStatusMessage(string $type, string $message): void
    {
        $list = request()->session()->get('status');
        $list[] = new StatusMessage($type, $message);

        $this->flashSessionMessages($list);
    }

    private function flashSessionMessages($data): void
    {
        request()->session()->flash('status', $data);
    }
}
