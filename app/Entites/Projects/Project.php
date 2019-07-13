<?php


namespace App\Entites\Projects;


use App\Entites\CustomModel;
use App\Entites\Translations\Translation;

class Project extends CustomModel
{
    protected $table = 'projects';

    public function translations()
    {
        return $this->belongsToMany(
            Translation::class,
            'ref_projects_translations',
            'project_id',
            'translation_id'
        );
    }
}
