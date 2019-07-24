<?php


namespace App\Entities\Translations;




use App\Entities\CustomReadModel;

/**
 * Class TranslationRM
 * @package App\Entites\Translations
 *
 * @property
 */
class TranslationRM extends Translation implements CustomReadModel
{
    protected $table = 'translations';

    protected $fillable = [];

    public function getId()
    {
        return $this->id;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getById($id): self
    {
        return parent::findOrFail($id);
    }

    public function getAll()
    {
        return parent::all();
    }

    public function getPaginated(int $itemsPerPage)
    {
        return parent::paginate($itemsPerPage);
    }
}
