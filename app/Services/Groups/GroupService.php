<?php


namespace App\Services\Groups;


use App\Entities\Groups\Group;
use App\Entities\Groups\GroupRM;
use App\Entities\StatusMessage;
use App\Http\Requests\Groups\GroupSearchRequest;
use App\Http\Requests\Groups\GroupStoreRequest;
use App\Http\Requests\Groups\GroupUpdateRequest;
use App\Services\CustomService;
use Exception;

class GroupService extends CustomService
{
    private $model;
    private $entity;

    public function __construct(Group $entity, GroupRM $model)
    {
        $this->model = $model;
        $this->entity = $entity;
    }

    public function search(GroupSearchRequest $request, int $itemsPerPage): array
    {
        $query = $this->model;
        $object = (object)[];

        if (!empty($request->input()))
            list($query, $object) = $this->formSearch($request, $query, $object);

        return [$query->paginate($itemsPerPage), $object];
    }

    private function formSearch(GroupSearchRequest $request, GroupRM $query, $object): array
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

    public function create(GroupStoreRequest $request): void
    {
        $item = $this->entity->create([
            'name' => $request->input('name'),
            'description' => $request->input('description')
        ]);

        $this->saveTranslations($request->input('translations'), $item);

        if ($request->input('translations') != null && !empty($request->input('translations')))

            $this->fireStatusMessage(StatusMessage::TYPES['success'], "Group \"$item->name\" was successfully created");
        return;
    }

    public function update(GroupUpdateRequest $request, Group $item): void
    {
        $item->name = $request->input('name');
        $item->description = $request->input('description');
        $item->save();

        $this->saveTranslations($request->input('translations'), $item);

        $this->fireStatusMessage(StatusMessage::TYPES['success'], "Group \"$item->name\" was successfully modified");
        return;
    }

    public function destroy(Group $item): void
    {
        $name = $item->name;
        $item->delete();

        $this->fireStatusMessage(StatusMessage::TYPES['success'], "Group \"$name\" was successfully deleted");
    }

    private function saveTranslations(?array $translations, Group $group)
    {
        try {
            if (isset($translations) && !empty($translations))
                $group->translations()->sync($translations);
        } catch (Exception $exception) {
            $message = $exception->getMessage();
            $this->fireStatusMessage(StatusMessage::TYPES['danger'], "Translations error:\"$message\"");
        }
    }
}
