<?php


namespace App\Services\Languages;


use App\Entities\Languages\Language;
use App\Entities\Languages\LanguageRM;
use App\Entities\StatusMessage;
use App\Http\Requests\Languages\LanguageSearchRequest;
use App\Http\Requests\Languages\LanguageStoreRequest;
use App\Http\Requests\Languages\LanguageUpdateRequest;
use App\Services\CustomService;

class LanguageService extends CustomService
{
    private $model;
    private $entity;

    public function __construct(Language $entity, LanguageRM $model)
    {
        $this->model = $model;
        $this->entity = $entity;
    }

    public function search(LanguageSearchRequest $request, int $itemsPerPage): array
    {
        $query = $this->model;
        $object = (object)[];

        if (!empty($request->input()))
            list($query, $object) = $this->formSearch($request, $query, $object);

        return [$query->paginate($itemsPerPage), $object];
    }

    private function formSearch(LanguageSearchRequest $request, LanguageRM $query, $object): array
    {
        $found = false;

        if ($request->input('code')) {
            $object->id = $request->input('code');
            $query = $query->where('code', '=', $request->input('code'));
            $found = 1;
        }

        if ($request->input('name')) {
            $object->name = $request->input('name');
            $query = $query->where('name', 'LIKE', "%$object->name%");
            $found = 1;
        }

        if (!$found) {
            $query = $this->model;
            $this->fireStatusMessage(StatusMessage::TYPES['warning'], 'Nothing was found according to your query');
        }else
            $this->fireStatusMessage(StatusMessage::TYPES['success'], sprintf('%d results were found', $query->count()));

        return [$query, $object];
    }

    public function create(LanguageStoreRequest $request): void
    {
        $item = $this->entity->create([
            'code' => $request->input('code'),
            'name' => $request->input('name')
        ]);

        $this->fireStatusMessage(StatusMessage::TYPES['success'], "$item->name Language was successfully created");
        return;
    }

    public function update(LanguageUpdateRequest $request, Language $item): void
    {
        $item->name = $request->input('name');
        $item->save();

        $this->fireStatusMessage(StatusMessage::TYPES['success'], "$item->name Language was successfully modified");
        return;
    }

    public function destroy(Language $item): void
    {
        $name = $item->name;
        $item->delete();

        $this->fireStatusMessage(StatusMessage::TYPES['success'], "$name Language was successfully deleted");
    }
}
