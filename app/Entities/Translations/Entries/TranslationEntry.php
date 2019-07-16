<?php


namespace App\Entities\Translations\Entries;


use App\Entities\CustomModel;
use App\Entities\Languages\Language;
use App\Entities\Translations\Translation;

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
    protected $table = 'translations_entries';

    public function getByParams(int $translationId, string $languageCode): self
    {
        $item = $this->where('translation_id', '=', $translationId)
            ->where('language_code', $languageCode)->first();

        return isset($item) ? $item : $this;
    }

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
