<?php


namespace App\Services\Translations;


use App\Entities\Translations\Entries\TranslationEntry;
use App\Entities\Translations\Translation;
use App\Services\CustomService;
use Illuminate\Http\Request;

class TranslationEntryService extends CustomService
{
    private $entity;

    public function __construct(TranslationEntry $entity)
    {
        $this->entity = $entity;
    }

    public function saveFromTranslation(Request $request, Translation $translation): void
    {
        $list = [];

        foreach ($request->input('entries') as $key => $entry) {
            $item = $this->entity->getByParams($translation->id, $key);

            $item->fill([
                'translation_id' => $translation->id,
                'language_code' => $key,
                'entry' => $entry
            ]);

            $list[] = $item;
        }

        $translation->entries()->saveMany($list);
    }
}
