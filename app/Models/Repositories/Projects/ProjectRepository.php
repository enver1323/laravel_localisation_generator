<?php


namespace App\Models\Repositories\Projects;


use App\Models\Entities\Projects\Project;
use App\Models\Repositories\CustomRepository;
use Illuminate\Support\Collection;

class ProjectRepository extends CustomRepository
{
    private $entity;

    public function __construct(Project $entity)
    {
        $this->entity = $entity;
    }

    public function all(): Collection
    {
        return $this->entity->all();
    }

    public function find($item)
    {
        return $this->entity->findOrFail($item);
    }

    /**
     * @param string|null $name
     * @param string|null $description
     * @return Project
     */
    public function getEntity(string $name = null, string $description = null): Project
    {
        $item = new $this->entity();

        $item->name = $name;
        $item->description = $description;

        return $item;
    }
}
