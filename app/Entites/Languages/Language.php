<?php


namespace App\Entites\Languages;


use App\Entites\CustomModel;
use App\Entites\Translations\Translation;
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
}
