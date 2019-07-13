<?php


namespace App\Entites;



interface CustomReadModel
{
    public function getById($id);

    public function getAll();

    public function getPaginated(int $itemsPerPage);
}
