<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CustomResourceCollection extends ResourceCollection
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;

        parent::__construct($data);
    }

    public function toArray($request)
    {
        return [
            'data' => $this->data
        ];
    }
}
