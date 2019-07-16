<?php


namespace App\Entities\Projects;


use App\Entities\CustomReadModel;
use App\Entities\CustomModel;

class ProjectRM extends Project implements CustomReadModel
{
    protected $table = 'projects';

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
