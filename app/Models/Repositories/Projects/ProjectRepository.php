<?php


namespace App\Models\Repositories\Projects;


use App\Http\Requests\Projects\ProjectAddGroupsRequest;
use App\Http\Requests\Projects\ProjectSearchRequest;
use App\Models\Entities\Projects\Project;
use App\Models\Repositories\CustomRepository;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Throwable;

class ProjectRepository extends CustomRepository
{
    /**
     * @var Project
     */
    private $entity;

    public function __construct(Project $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->entity->all();
    }

    /**
     * @param $item
     * @return Project|Collection
     */
    public function find($item)
    {
        return $this->entity->findOrFail($item);
    }

    /**
     * @param int $itemsPerPage
     * @return LengthAwarePaginator
     */
    public function paginate(int $itemsPerPage): LengthAwarePaginator
    {
        return $this->entity->paginate($itemsPerPage);
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

    /**
     * @param Project $item
     * @return bool
     * @throws Throwable
     */
    public function save(Project $item): bool
    {
        return $item->saveOrFail();
    }

    /**
     * @param string $name
     * @param string $description
     * @return Project
     * @throws Throwable
     */
    public function create(string $name, string $description): Project
    {
        $item = $this->getEntity($name, $description);

        $this->save($item);

        return $item;
    }

    /**
     * @param Project $item
     * @throws Exception
     */
    public function delete(Project $item): void
    {
        $item->delete();
    }

    /**
     * @param ProjectSearchRequest $request
     * @param int $itemsPerPage
     * @return LengthAwarePaginator
     */
    public function formSearch(ProjectSearchRequest $request, int $itemsPerPage): LengthAwarePaginator
    {
        $query = $this->entity;

        if ($request->id)
            $query = $query->where('id', '=', $request->id);

        if ($request->input('name'))
            $query = $query->where('name', 'LIKE', "%$request->name%");

        return $query->paginate($itemsPerPage);
    }

    /**
     * @param ProjectAddGroupsRequest $request
     */
    public function attachGroups(ProjectAddGroupsRequest $request): void
    {
        $this->find($request->project)->groups()->syncWithoutDetaching($request->groups);
    }
}
