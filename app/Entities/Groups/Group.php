<?php


namespace App\Entities\Groups;


use App\Entities\CustomModel;
use App\Entities\Projects\Project;
use App\Entities\Translations\Translation;
use Illuminate\Support\Collection;

/**
 * Class Group
 * @package App\Entities\Groups
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 *
 * Relations:
 * @property Collection $translations
 * @property Collection $projects
 */
class Group extends CustomModel
{
    protected $table = 'groups';

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
            'ref_groups_translations',
            'group_id',
            'translation_id'
        );
    }

    public function projects()
    {
        return $this->belongsToMany(
            Project::class,
            'ref_projects_groups',
            'group_id',
            'project_id'
        );
    }
}
