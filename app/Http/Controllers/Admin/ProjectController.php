<?php


namespace App\Http\Controllers\Admin;


use App\Entities\Projects\Project;
use App\Entities\Projects\ProjectRM;
use App\Http\Requests\Projects\ProjectSearchRequest;
use App\Http\Requests\Projects\ProjectStoreRequest;
use App\Http\Requests\Projects\ProjectUpdateRequest;
use App\Services\Projects\ProjectService;

class ProjectController extends AdminController
{
    private function getView(string $view): string
    {
        return sprintf('projects.%s', $view);
    }

    public function __construct(ProjectService $service)
    {
        $this->service = $service;
    }

    public function index(ProjectSearchRequest $request)
    {
        list($items, $queryObject) = $this->service->search($request, self::ITEMS_PER_PAGE);

        return $this->render($this->getView('projectIndex'), [
            'items' => $items,
            'searchQuery' => $queryObject,
        ]);
    }

    public function create()
    {
        return $this->render($this->getView('projectCreate'));
    }

    public function store(ProjectStoreRequest $request)
    {
        $this->service->create($request);

        return redirect()->route('admin.projects.index');
    }

    public function show(ProjectRM $project)
    {
        return $this->render($this->getView('projectShow'), [
            'item' => $project
        ]);
    }

    public function edit(ProjectRM $project)
    {
        return $this->render($this->getView('projectEdit'), [
            'item' => $project
        ]);
    }

    public function update(ProjectUpdateRequest $request, Project $project)
    {
        $this->service->update($request, $project);

        return redirect()->route('admin.projects.show', [
            'item' => $project
        ]);
    }

    public function destroy(Project $project)
    {
        $this->service->destroy($project);

        return redirect()->route('admin.projects.index');
    }

    public function export(ProjectRM $project)
    {
        $this->service->export($project);

        return redirect()->route('admin.projects.index');
    }
}
