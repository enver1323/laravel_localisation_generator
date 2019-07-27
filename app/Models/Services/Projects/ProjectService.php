<?php


namespace App\Models\Services\Projects;


use App\Models\Entities\Projects\Project;
use App\Http\Requests\Projects\ProjectAddGroupsRequest;
use App\Http\Requests\Projects\ProjectExportRequest;
use App\Http\Requests\Projects\ProjectSearchRequest;
use App\Http\Requests\Projects\ProjectStoreRequest;
use App\Http\Requests\Projects\ProjectUpdateRequest;
use App\Models\Repositories\Projects\ProjectRepository;
use App\Models\Services\CustomService;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Throwable;

class ProjectService extends CustomService
{
    /**
     * @var ProjectRepository
     */
    private $projects;
    /**
     * @var ProjectExportService
     */
    private $exportService;

    public function __construct(ProjectRepository $projects, ProjectExportService $exportService)
    {
        $this->projects = $projects;
        $this->exportService = $exportService;
    }

    /**
     * @param ProjectSearchRequest $request
     * @param int $itemsPerPage
     * @return LengthAwarePaginator
     */
    public function search(ProjectSearchRequest $request, int $itemsPerPage): LengthAwarePaginator
    {
        if (!empty($request->validated()))
            return $this->projects->formSearch($request, $itemsPerPage);

        return $this->projects->paginate($itemsPerPage);
    }

    /**
     * @param ProjectStoreRequest $request
     * @return Project
     * @throws Throwable
     */
    public function create(ProjectStoreRequest $request): Project
    {
        return $this->projects->create($request->name, $request->description);
    }

    /**
     * @param ProjectUpdateRequest $request
     * @param Project $item
     * @return Project
     * @throws Throwable
     */
    public function update(ProjectUpdateRequest $request, Project $item): Project
    {
        $item->name = $request->name;
        $item->description = $request->description;
        $this->projects->save($item);

        return $item;
    }

    /**
     * @param Project $item
     * @return string
     * @throws Exception
     */
    public function destroy(Project $item): string
    {
        $name = $item->name;
        $this->projects->delete($item);

        return $name;
    }

    /**
     * @param ProjectExportRequest $request
     * @param Project $project
     * @return string|null
     */
    public function export(ProjectExportRequest $request, Project $project): ?string
    {
        $path = '';

        if($request->input('type') === ProjectExportService::$types['json'])
            $path = $this->exportService->json($project, $request->input('languages'));

        if($request->input('type') === ProjectExportService::$types['archive'])
            $path = $this->exportService->archive($project, $request->input('languages'));

        return $path;
    }

    /**
     * @param ProjectAddGroupsRequest $request
     */
    public function attachGroups(ProjectAddGroupsRequest $request): void
    {
        $this->projects->attachGroups($request);
    }
}
