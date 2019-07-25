<?php


namespace App\Services\Projects;


use App\Entities\Projects\Project;
use App\Entities\Projects\ProjectRM;
use App\Entities\StatusMessage;
use App\Http\Requests\Projects\ProjectAddGroupsRequest;
use App\Http\Requests\Projects\ProjectExportRequest;
use App\Http\Requests\Projects\ProjectSearchRequest;
use App\Http\Requests\Projects\ProjectStoreRequest;
use App\Http\Requests\Projects\ProjectUpdateRequest;
use App\Services\CustomService;

class ProjectService extends CustomService
{
    private $model;
    private $entity;
    private $exportService;

    public function __construct(Project $entity, ProjectRM $model, ProjectExportService $exportService)
    {
        $this->model = $model;
        $this->entity = $entity;
        $this->exportService = $exportService;
    }

    public function search(ProjectSearchRequest $request, int $itemsPerPage): array
    {
        $query = $this->model;
        $object = (object)[];

        if (!empty($request->input()))
            list($query, $object) = $this->formSearch($request, $query, $object);

        return [$query->paginate($itemsPerPage), $object];
    }

    private function formSearch(ProjectSearchRequest $request, ProjectRM $query, $object): array
    {
        if ($request->input('id')) {
            $object->id = $request->input('id');
            $query = $query->where('id', '=', $request->input('id'));
        }

        if ($request->input('name')) {
            $object->name = $request->input('name');
            $query = $query->where('name', 'LIKE', "%$object->name%");
        }

        if (!$query->count()) {
            $query = $this->model;
            $this->fireStatusMessage(StatusMessage::TYPES['warning'], 'Nothing was found according to your query');
        }

        return [$query, $object];
    }

    public function create(ProjectStoreRequest $request): void
    {
        $item = $this->entity->create([
            'name' => $request->input('name'),
            'description' => $request->input('description')
        ]);

        $this->fireStatusMessage(StatusMessage::TYPES['success'], "Project \"$item->name\" was successfully created");
        return;
    }

    public function update(ProjectUpdateRequest $request, Project $item): void
    {
        $item->name = $request->input('name');
        $item->description = $request->input('description');
        $item->save();

        $this->fireStatusMessage(StatusMessage::TYPES['success'], "Project \"$item->name\" was successfully modified");
        return;
    }

    public function destroy(Project $item): void
    {
        $name = $item->name;
        $item->delete();

        $this->fireStatusMessage(StatusMessage::TYPES['success'], "Project \"$name\" was successfully deleted");
    }

    public function export(ProjectExportRequest $request, ProjectRM $project): ?string
    {
        $path = '';

        if($request->input('type') === ProjectExportService::$types['json'])
            $path = $this->exportService->json($project, $request->input('languages'));

        if($request->input('type') === ProjectExportService::$types['archive'])
            $path = $this->exportService->archive($project, $request->input('languages'));

        $this->fireStatusMessage(StatusMessage::TYPES['success'], 'File was successfully generated');

        return $path;
    }

    public function attachGroups(ProjectAddGroupsRequest $request): void
    {
        $this->model->getById($request->input('project'))->groups()
            ->syncWithoutDetaching($request->input('groups'));

        $this->fireStatusMessage(StatusMessage::TYPES['success'], "Groups were successfully attached");
    }
}
