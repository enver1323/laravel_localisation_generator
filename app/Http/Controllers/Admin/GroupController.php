<?php


namespace App\Http\Controllers\Admin;


use App\Entities\Groups\GroupRM;
use App\Entities\Projects\ProjectRM;
use App\Http\Requests\Groups\GroupSearchRequest;
use App\Http\Requests\Groups\GroupStoreRequest;
use App\Http\Requests\Groups\GroupUpdateRequest;
use App\Services\Groups\GroupService;

class GroupController extends AdminController
{
    private $projects;

    private function getView(string $view): string
    {
        return sprintf('groups.%s', $view);
    }

    public function __construct(GroupService $service, ProjectRM $projects)
    {
        $this->service = $service;
        $this->projects = $projects;
    }

    public function index(GroupSearchRequest $request)
    {
        list($items, $queryObject) = $this->service->search($request, self::ITEMS_PER_PAGE);

        return $this->render($this->getView('groupIndex'), [
            'items' => $items,
            'projects' => $this->projects->getAll(),
            'searchQuery' => $queryObject,
        ]);
    }

    public function create()
    {
        return $this->render($this->getView('groupCreate'), [
            'projects' => $this->projects->getAll(),
        ]);
    }

    public function store(GroupStoreRequest $request)
    {
        $this->service->create($request);

        return redirect()->route('admin.groups.index');
    }

    public function show(GroupRM $group)
    {
        return $this->render($this->getView('groupShow'), [
            'item' => $group
        ]);
    }

    public function edit(GroupRM $group)
    {
        return $this->render($this->getView('groupEdit'), [
            'item' => $group,
            'projects' => $this->projects->getAll(),
        ]);
    }

    public function update(GroupUpdateRequest $request, GroupRM $group)
    {
        $this->service->update($request, $group);

        return redirect()->route('admin.groups.show', [
            'item' => $group
        ]);
    }

    public function destroy(GroupRM $group)
    {
        $this->service->destroy($group);

        return redirect()->route('admin.groups.index');
    }
}
