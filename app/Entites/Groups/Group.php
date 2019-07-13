<?php


namespace App\Entites\Groups;


use App\Entites\CustomModel;
use App\Entites\Translations\Translation;

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
