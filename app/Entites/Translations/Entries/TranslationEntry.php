<?php


namespace App\Entites\Translations\Entries;


use App\Entites\CustomModel;
use App\Entites\Languages\Language;
use App\Entites\Translations\Translation;

/**
 * Class TranslationEntryModel
 * @package App\Entites\Translations\Entries
 *
 * @property integer $id
 * @property integer $translation_id
 * @property string $language_code
 * @property string $entry
 *
 * Relations:
 * @property Translation $translation
 * @property Language $language
 */
class TranslationEntry extends CustomModel
{
    protected $table = 'translation_entries';

    public function translation()
    {
        return $this->belongsTo(
            Translation::class,
            'translation_id',
            'id');
    }

    public function language()
    {
        return $this->belongsTo(
            Language::class,
            'language_code',
            'code');
    }
}
