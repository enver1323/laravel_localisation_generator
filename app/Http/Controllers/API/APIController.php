<?php


namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Http\Resources\CustomResourceCollection;

class APIController extends Controller
{
    protected function render($data)
    {
        return new CustomResourceCollection($data);
    }
}
