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
}
