<?php


namespace App\Entities\Projects;


use App\Entities\CustomModel;
use App\Entities\Translations\Translation;
use Illuminate\Support\Collection;

/**
 * Class Project
 * @package App\Entities\Projects
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 *
 * Relations:
 * @property Collection $translations
 */
class Project extends CustomModel
{
    protected $table = 'projects';

    public function getShortDescription()
    {
        $desc = $this->description;

        if (strlen($desc) >= 100)
            return substr($desc, 0, 100). " ... ";

        return $desc;
    }

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
