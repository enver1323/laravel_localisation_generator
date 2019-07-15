<?php


namespace App\Entities\Users;


use App\Entities\CustomReadModel;

class UserRM extends User implements CustomReadModel
{

    public function getById($id): self
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
