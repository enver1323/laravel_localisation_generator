<?php


namespace App\Models\Entities;


use Illuminate\Database\Eloquent\Model;

abstract class CustomEntity extends Model
{
    public $timestamps = false;

    protected $fillable = [];
}
