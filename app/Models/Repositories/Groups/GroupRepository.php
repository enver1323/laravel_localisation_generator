<?php


namespace App\Models\Repositories\Groups;


use App\Http\Requests\Groups\GroupAddTranslationsRequest;
use App\Http\Requests\Groups\GroupSearchRequest;
use App\Models\Entities\Groups\Group;
use App\Models\Repositories\CustomRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Throwable;

class GroupRepository extends CustomRepository
{
    /**
     * @var Group
     */
    private $entity;

    public function __construct(Group $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return Collection|null
     */
    public function all(): ?Collection
    {
        return $this->entity->all();
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
     * @param $item
     * @return Group|Collection
     */
    public function find($item)
    {
        return $this->entity->findOrFail($item);
    }

    /**
     * @param string|null $name
     * @param string|null $description
     * @return Group
     */
    public function getEntity(string $name = null, string $description = null): Group
    {
        $item = new $this->entity();

        $item->name = $name;
        $item->description = $description;

        return $item;
    }

    /**
     * @param Group $item
     * @return bool
     * @throws Throwable
     */
    public function save(Group $item): bool
    {
        return $item->saveOrFail();
    }

    /**
     * @param string $name
     * @param string $description
     * @return Group
     * @throws Throwable
     */
    public function create(string $name, string $description): Group
    {
        $item = $this->getEntity($name, $description);
        $this->save($item);

        return $item;
    }

    /**
     * @param Group $item
     * @throws \Exception
     */
    public function delete(Group $item): void
    {
        $item->delete();
    }

    /**
     * @param GroupAddTranslationsRequest $request
     */
    public function attachTranslations(GroupAddTranslationsRequest $request): void
    {
        $item = $this->find($request->group);
        $item->translations()->syncWithoutDetaching($request->translations);
    }

    /**
     * @param Group $item
     * @param array|null $projects
     */
    public function syncProjects(Group $item, ?array $projects): void
    {
        $item->projects()->sync($projects);
    }

    /**
     * @param GroupSearchRequest $request
     * @param int $itemsPerPage
     * @return LengthAwarePaginator
     */
    public function formSearch(GroupSearchRequest $request, int $itemsPerPage): LengthAwarePaginator
    {
        $query = $this->entity;

        if ($request->input('id'))
            $query = $query->where('id', '=', $request->input('id'));

        if ($request->name)
            $query = $query->where('name', 'LIKE', $request->name);

        if ($request->projects && !empty($request->projects))
            foreach ($request->projects as $project)
                $query = $this->entity->whereHas('projects', function (Builder $query) use ($project) {
                    $query->where('id', '=', $project);
                });

        return $query->paginate($itemsPerPage);
    }
}
