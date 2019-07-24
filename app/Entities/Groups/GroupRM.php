<?php


namespace App\Entities\Groups;


use App\Entities\CustomReadModel;

class GroupRM extends Group implements CustomReadModel
{

    public function getById($id)
    {
        return $this->find($id);
    }

    public function getAll()
    {
        return parent::all();
    }

    public function getPaginated(int $itemsPerPage)
    {
        return $this->paginate($itemsPerPage);
    }
}
