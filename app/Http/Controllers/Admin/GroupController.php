<?php


namespace App\Http\Controllers\Admin;


use App\Http\Requests\Groups\GroupAddTranslationsRequest;
use App\Http\Requests\Groups\GroupSearchRequest;
use App\Http\Requests\Groups\GroupStoreRequest;
use App\Http\Requests\Groups\GroupUpdateRequest;
use App\Models\Entities\Groups\Group;
use App\Models\Entities\StatusMessage;
use App\Models\Repositories\Projects\ProjectRepository;
use App\Models\Services\Groups\GroupService;
use App\Models\Services\StatusMessages\StatusMessageService;
use Exception;

class GroupController extends AdminController
{
    private $projects;

    private function getView(string $view): string
    {
        return sprintf('groups.%s', $view);
    }

    public function __construct(GroupService $service, ProjectRepository $projects, StatusMessageService $messageService)
    {
        $this->service = $service;
        $this->projects = $projects;
        $this->messageService = $messageService;
    }

    public function index(GroupSearchRequest $request)
    {
        return $this->render($this->getView('groupIndex'), [
            'items' => $this->service->search($request, self::ITEMS_PER_PAGE),
            'projects' => $this->projects->all(),
        ]);
    }

    public function create()
    {
        return $this->render($this->getView('groupCreate'), [
            'projects' => $this->projects->all(),
        ]);
    }

    public function store(GroupStoreRequest $request)
    {
        try{
            $this->messageService->fireMessage(StatusMessage::TYPES['success'], __('adminGroup.createSuccess', [
                'name' => $this->service->create($request)->name,
            ]));
        }catch (Exception $exception){
            $this->messageService->fireMessage(StatusMessage::TYPES['danger'], $exception->getMessage());
        }

        return redirect()->route('admin.groups.index');
    }

    public function show(Group $group)
    {
        return $this->render($this->getView('groupShow'), [
            'item' => $group
        ]);
    }

    public function edit(Group $group)
    {
        return $this->render($this->getView('groupEdit'), [
            'item' => $group,
            'projects' => $this->projects->all(),
        ]);
    }

    public function update(GroupUpdateRequest $request, Group $group)
    {
        try{
            $group = $this->service->update($request, $group);
            $this->messageService->fireMessage(StatusMessage::TYPES['success'], __('adminGroup.updateSuccess', [
                'name' => $group->name,
            ]));
        }catch (Exception $exception){
            $this->messageService->fireMessage(StatusMessage::TYPES['success'], $exception->getMessage());
        }

        return redirect()->route('admin.groups.show', [
            'item' => $group
        ]);
    }

    public function destroy(Group $group)
    {
        try{
            $this->messageService->fireMessage(StatusMessage::TYPES['success'], __('adminGroup.destroySuccess', [
                'name' => $this->service->destroy($group),
            ]));
        }catch (Exception $exception){
            $this->messageService->fireMessage(StatusMessage::TYPES['success'], $exception->getMessage());
        }

        return redirect()->route('admin.groups.index');
    }

    public function attachTranslations(GroupAddTranslationsRequest $request)
    {
        $this->service->attachTranslations($request);
        $this->messageService->fireMessage(StatusMessage::TYPES['success'], __('adminGroup.attachTranslationsSuccess'));

        return redirect()->back();
    }
}
