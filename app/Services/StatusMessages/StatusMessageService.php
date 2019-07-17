<?php


namespace App\Services\StatusMessages;


use App\Entities\StatusMessage;
use App\Services\CustomService;

class StatusMessageService extends CustomService
{
    public static function fireMessage(string $type, string $message): void
    {
        $list = request()->session()->get('status');
        $statusMessage = new StatusMessage($type, $message);

        if(self::messageNotPending($statusMessage, $list))
            $list[] = $statusMessage;

        self::flashSessionMessages($list);
    }

    private static function flashSessionMessages(array $data): void
    {
        request()->session()->flash('status', $data);
    }

    private static function messageNotPending(StatusMessage $message, ?array $list = []): bool
    {

        return $list === null || empty(array_filter($list, function($item)use($message){
            return $item->message === $message->message && $item->type === $message->type;
        }));
    }
}
