<?php


namespace App\Models\Entities\Languages;


use App\Models\Entities\CustomEntity;
use App\Models\Entities\Translations\Entries\TranslationEntry;
use App\Models\Entities\Translations\Translation;
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
class Language extends CustomEntity
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

    public function getFilledPercentage(): int
    {
        $entriesCount = Translation::count();

        if($entriesCount)
            return $this->translations()->count() / $entriesCount * 100;

        return 0;
    }
}
