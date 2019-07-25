<?php


namespace App\Http\Controllers\Admin;


use App\Entities\Projects\Project;
use App\Entities\Projects\ProjectRM;
use App\Http\Requests\Projects\ProjectAddGroupsRequest;
use App\Http\Requests\Projects\ProjectExportRequest;
use App\Http\Requests\Projects\ProjectSearchRequest;
use App\Http\Requests\Projects\ProjectStoreRequest;
use App\Http\Requests\Projects\ProjectUpdateRequest;
use App\Services\Projects\ProjectService;
use Illuminate\View\View;

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

    public function index(ProjectSearchRequest $request): View
    {
        list($items, $queryObject) = $this->service->search($request, self::ITEMS_PER_PAGE);

        return $this->render($this->getView('projectIndex'), [
            'items' => $items,
            'searchQuery' => $queryObject,
        ]);
    }

    public function create(): View
    {
        return $this->render($this->getView('projectCreate'));
    }

    public function store(ProjectStoreRequest $request)
    {
        $this->service->create($request);

        return redirect()->route('admin.projects.index');
    }

    public function show(ProjectRM $project): View
    {
        return $this->render($this->getView('projectShow'), [
            'item' => $project
        ]);
    }

    public function edit(ProjectRM $project): View
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

    public function setUpExport(ProjectRM $project): View
    {
        return $this->render($this->getView('projectExport'), [
            'item' => $project,
            'languages' => $project->getLanguages()
        ]);
    }

    public function export(ProjectExportRequest $request, ProjectRM $project)
    {
        $path = $this->service->export($request, $project);

        return response()->download($path)->deleteFileAfterSend();
    }

    public function attachGroups(ProjectAddGroupsRequest $request)
    {
        $this->service->attachGroups($request);

        return redirect()->back();
    }
}
