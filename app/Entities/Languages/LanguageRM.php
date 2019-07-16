<?php


namespace App\Entities\Languages;


use App\Entities\CustomReadModel;
use App\Entities\Translations\TranslationRM;

class LanguageRM extends Language implements CustomReadModel
{
    protected $table = 'languages';

    public function getById($id)
    {
        return $this->findOrFail($id);
    }

    public function getAll()
    {
        return $this->all();
    }

    public function getPaginated(int $itemsPerPage)
    {
        return $this->paginate($itemsPerPage);
    }

    public function getFilledPercentage(): int
    {
        $entriesCount = TranslationRM::count();

        if($entriesCount)
            return $this->translations()->count() / $entriesCount * 100;

        return 0;
    }
}
