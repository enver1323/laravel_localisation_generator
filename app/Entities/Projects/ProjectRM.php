<?php


namespace App\Entities\Projects;


use App\Entities\CustomReadModel;
use App\Entities\CustomModel;

class ProjectRM extends Project implements CustomReadModel
{
    protected $table = 'projects';
}
