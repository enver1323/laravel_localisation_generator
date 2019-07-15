<?php


namespace App\Entities\Languages;


use App\Entities\CustomModel;
use App\Entities\Translations\Entries\TranslationEntry;
use App\Entities\Translations\Translation;
use Illuminate\Support\Collection;

/**
 * Class LanguageModel
 * @package App\Entites\Languages
 *
 * @property string $code
 * @property string $name
 *
 * Relations:
 * @property Collection $translations
 * @property Collection $entries
 */
class Language extends CustomModel
{
    protected $table = 'languages';

    protected $primaryKey = 'code';

    public $incrementing = false;

    public function translations()
    {
        return $this->belongsToMany(Translation::class,
            'translations_entries',
            'language_code',
            'translation_id'
        )->withPivot('entry');
    }

    public function entries()
    {
        return $this->hasMany(TranslationEntry::class,
            'language_code',
            'code'
        );
    }
}
