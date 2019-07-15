<?php


namespace App\Entities;


/**
 * Class StatusMessage
 * @package App\Entities
 *
 * @property string $message
 * @property string $status
 */
class StatusMessage
{
    const TYPES = [
        'success' => 'success',
        'danger' => 'danger',
        'warning' => 'warning'
    ];

    public $message;
    public $type;

    public function __construct(string $type, string $message)
    {
        $this->type = $type;
        $this->message = $message;
    }
}
