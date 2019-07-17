<?php


namespace App\Services\Translations;


use App\Entities\Translations\Entries\TranslationEntry;
use App\Entities\Translations\Translation;
use App\Services\CustomService;

class TranslationEntryService extends CustomService
{
    private $entity;

    public function __construct(TranslationEntry $entity)
    {
        $this->entity = $entity;
    }

    public function saveFromTranslation(array $entries, Translation $translation): void
    {
        $list = [];

        foreach ($entries as $key => $entry) {
            $item = new $this->entity();
            $item = $item->getByParams($translation->id, $key);

            $item->translation_id = $translation->id;
            $item->language_code = $key;
            $item->entry = $entry;

            $list[] = $item;
        }

        $translation->entries()->saveMany($list);
    }
}
