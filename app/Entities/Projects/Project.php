<?php


namespace App\Entities\Projects;


use App\Entities\CustomModel;
use App\Entities\Groups\Group;
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
 * @property Collection $groups
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

    public function groups()
    {
        return $this->belongsToMany(
            Group::class,
            'ref_projects_groups',
            'project_id',
            'group_id'
        );
    }
}
