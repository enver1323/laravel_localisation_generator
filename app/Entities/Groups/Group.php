<?php


namespace App\Entities\Groups;


use App\Entities\CustomModel;
use App\Entities\Translations\Translation;

class Group extends CustomModel
{
    protected $table = 'groups';

    public function translations()
    {
        return $this->belongsToMany(
            Translation::class,
            'ref_groups_translations',
            'group_id',
            'translation_id'
        );
    }
}
