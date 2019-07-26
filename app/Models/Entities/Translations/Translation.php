<?php


namespace App\Models\Entities\Translations;


use App\Models\Entities\CustomEntity;
use App\Models\Entities\Groups\Group;
use App\Models\Entities\Languages\Language;
use App\Models\Entities\Translations\Entries\TranslationEntry;
use Illuminate\Support\Collection;

/**
 * Class TranslationModel
 * @package App\Entites\Translations
 *
 * @property integer $id
 * @property string $key
 *
 * Relations:
 * @property Collection $languages
 * @property Collection $entries
 * @property Collection $groups
 */
class Translation extends CustomEntity
{
    protected $table = 'translations';

    protected $guarded = [];

    public function getEntry(string $lang) : string
    {
        return $this->entries()->where('language_code', '=', $lang)->first()->entry;
    }

    public function groups()
    {
        return $this->belongsToMany(
            Group::class,
            'ref_groups_translations',
            'translation_id',
            'group_id');
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class,
            'translations_entries',
            'translation_id',
            'language_code'
        );
    }

    public function entries()
    {
        return $this->hasMany(
            TranslationEntry::class,
            'translation_id',
            'id');
    }
}
