<?php


namespace App\Entities\Projects;


use App\Entities\CustomModel;
use App\Entities\Translations\Translation;

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
