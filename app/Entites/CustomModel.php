<?php


namespace App\Entites;


use Illuminate\Database\Eloquent\Model;

abstract class CustomModel extends Model
{
    public $timestamps = false;

    protected $guarded = [];
}
