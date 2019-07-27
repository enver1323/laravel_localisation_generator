<?php


namespace App\Http\Controllers\Admin;


use App\Http\Requests\Projects\ProjectAddGroupsRequest;
use App\Http\Requests\Projects\ProjectExportRequest;
use App\Http\Requests\Projects\ProjectSearchRequest;
use App\Http\Requests\Projects\ProjectStoreRequest;
use App\Http\Requests\Projects\ProjectUpdateRequest;
use App\Models\Entities\Projects\Project;
use App\Models\Entities\StatusMessage;
use App\Models\Services\Projects\ProjectService;
use App\Models\Services\StatusMessages\StatusMessageService;
use Exception;
use Illuminate\View\View;

class ProjectController extends AdminController
{
    private function getView(string $view): string
    {
        return sprintf('projects.%s', $view);
    }

    public function __construct(ProjectService $service, StatusMessageService $messageService)
    {
        $this->service = $service;
        $this->messageService = $messageService;
    }

    public function index(ProjectSearchRequest $request): View
    {
        return $this->render($this->getView('projectIndex'), [
            'items' => $this->service->search($request, self::ITEMS_PER_PAGE),
        ]);
    }

    public function create(): View
    {
        return $this->render($this->getView('projectCreate'));
    }

    public function store(ProjectStoreRequest $request)
    {
        try {
            $this->messageService->fireMessage(StatusMessage::TYPES['success'], __('adminProject.createSuccess', [
                'name' => $this->service->create($request)->name
            ]));
        } catch (Exception $exception) {
            $this->messageService->fireMessage(StatusMessage::TYPES['danger'], $exception->getMessage());
        }

        return redirect()->route('admin.projects.index');
    }

    public function show(Project $project): View
    {
        return $this->render($this->getView('projectShow'), [
            'item' => $project
        ]);
    }

    public function edit(Project $project): View
    {
        return $this->render($this->getView('projectEdit'), [
            'item' => $project
        ]);
    }

    public function update(ProjectUpdateRequest $request, Project $project)
    {

        try {
            $this->messageService->fireMessage(StatusMessage::TYPES['success'], __('adminProject.updateSuccess', [
                'name' => $this->service->update($request, $project)->name
            ]));
        } catch (Exception $exception) {
            $this->messageService->fireMessage(StatusMessage::TYPES['danger'], $exception->getMessage());
        }

        return redirect()->route('admin.projects.show', [
            'item' => $project
        ]);
    }

    public function destroy(Project $project)
    {
        try {
            $this->messageService->fireMessage(StatusMessage::TYPES['success'], __('adminLanguage.destroySuccess', [
                'name' => $this->service->destroy($project)
            ]));
        } catch (Exception $exception) {
            $this->messageService->fireMessage(StatusMessage::TYPES['danger'], $exception->getMessage());
        }

        return redirect()->route('admin.projects.index');
    }

    public function setUpExport(Project $project): View
    {
        return $this->render($this->getView('projectExport'), [
            'item' => $project,
            'languages' => $project->getLanguages()
        ]);
    }

    public function export(ProjectExportRequest $request, Project $project)
    {
        try{
            $path = $this->service->export($request, $project);
            $this->messageService->fireMessage(StatusMessage::TYPES['success'], __('adminProject.exportSuccess'));
            return response()->download($path)->deleteFileAfterSend();
        }catch (Exception $exception) {
            $this->messageService->fireMessage(StatusMessage::TYPES['danger'], $exception->getMessage());
            return redirect()->back();
        }
    }

    public function attachGroups(ProjectAddGroupsRequest $request)
    {
        $this->service->attachGroups($request);

        return redirect()->back();
    }
}
