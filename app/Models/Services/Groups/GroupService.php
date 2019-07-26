<?php


namespace App\Models\Services\Groups;


use App\Http\Requests\Groups\GroupAddTranslationsRequest;
use App\Http\Requests\Groups\GroupSearchRequest;
use App\Http\Requests\Groups\GroupStoreRequest;
use App\Http\Requests\Groups\GroupUpdateRequest;
use App\Models\Entities\Groups\Group;
use App\Models\Entities\StatusMessage;
use App\Models\Repositories\Groups\GroupRepository;
use App\Models\Services\CustomService;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class GroupService extends CustomService
{
    /**
     * @var GroupRepository
     */
    private $groups;

    public function __construct(GroupRepository $groups)
    {
        $this->groups = $groups;
    }

    /**
     * @param GroupSearchRequest $request
     * @param int $itemsPerPage
     * @return LengthAwarePaginator|null
     */
    public function search(GroupSearchRequest $request, int $itemsPerPage): ?LengthAwarePaginator
    {
        if (!empty($request->validated()))
            return $this->groups->formSearch($request, $itemsPerPage);

        return $this->groups->paginate($itemsPerPage);
    }

    /**
     * @param GroupStoreRequest $request
     * @return Group
     * @throws \Throwable
     */
    public function create(GroupStoreRequest $request): Group
    {
        $item = $this->groups->create($request->name, $request->description);

        $this->syncProjects($item, $request->projects);

        return $item;
    }

    /**
     * @param GroupUpdateRequest $request
     * @param Group $item
     * @return Group
     * @throws \Throwable
     */
    public function update(GroupUpdateRequest $request, Group $item): Group
    {
        $item->name = $request->name;
        $item->description = $request->description;
        $this->groups->save($item);

        $this->syncProjects($item, $request->projects);

        return $item;
    }

    /**
     * @param Group $item
     * @return string
     * @throws Exception
     */
    public function destroy(Group $item): string
    {
        $name = $item->name;
        $this->groups->delete($item);

        return $name;
    }

    /**
     * @param Group $item
     * @param array|null $projects
     */
    private function syncProjects(Group $item, ?array $projects)
    {
        try {
            $item->projects()->sync($projects);
        } catch (Exception $exception) {
            $message = $exception->getMessage();
            $this->fireStatusMessage(StatusMessage::TYPES['danger'], $message);
        }
    }

    /**
     * @param GroupAddTranslationsRequest $request
     */
    public function attachTranslations(GroupAddTranslationsRequest $request): void
    {
        $this->groups->attachTranslations($request);
    }
}
