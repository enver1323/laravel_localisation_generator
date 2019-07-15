<?php


namespace App\Entities;



interface CustomReadModel
{
    public function getById($id);

    public function getAll();

    public function getPaginated(int $itemsPerPage);
}
