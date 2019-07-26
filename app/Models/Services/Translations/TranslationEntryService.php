<?php


namespace App\Models\Services\Translations;


use App\Models\Entities\Translations\Entries\TranslationEntry;
use App\Models\Entities\Translations\Translation;
use App\Models\Services\CustomService;

class TranslationEntryService extends CustomService
{
    private $entity;

    public function __construct(TranslationEntry $entity)
    {
        $this->entity = $entity;
    }
}
