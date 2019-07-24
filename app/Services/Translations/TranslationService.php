<?php


namespace App\Services\Translations;


use App\Entities\StatusMessage;
use App\Entities\Translations\Translation;
use App\Entities\Translations\TranslationRM;
use App\Http\Requests\Translations\TranslationSearchRequest;
use App\Http\Requests\Translations\TranslationStoreRequest;
use App\Http\Requests\Translations\TranslationUpdateRequest;
use App\Services\CustomService;
use Exception;
use Illuminate\Database\Eloquent\Builder;

class TranslationService extends CustomService
{
    private $model;
    private $entity;
    private $entryService;

    public function __construct(Translation $entity, TranslationRM $model, TranslationEntryService $entryService)
    {
        $this->model = $model;
        $this->entity = $entity;
        $this->entryService = $entryService;
    }

    public function search(TranslationSearchRequest $request, int $itemsPerPage): array
    {
        $query = $this->model;
        $object = (object)[];

        if (!empty($request->input()))
            list($query, $object) = $this->formSearch($request, $query, $object);

        return [$query->paginate($itemsPerPage), $object];
    }

    private function formSearch(TranslationSearchRequest $request, TranslationRM $query, $object): array
    {
        if ($request->input('id')) {
            $object->id = $request->input('id');
            $query = $query->where('id', '=', $request->input('id'));
        }

        if ($request->input('key')) {
            $object->key = $request->input('key');
            $query = $query->where('key', 'LIKE', "%$object->key%");
        }

        if ($request->input('languages') && !empty($request->input('languages'))) {
            $object->languages = $request->input('languages');

            foreach ($object->languages as $language)
                $query = $query->whereHas('languages', function (Builder $query) use ($language) {
                    $query->where('code', '=', $language);
                });
        }

        if ($request->input('groups') && !empty($request->input('groups'))) {
            $object->groups = $request->input('groups');
            foreach ($object->groups as $group)
                $query = $query->whereHas('groups', function (Builder $query) use ($group) {
                    $query->where('id', '=', $group);
                });
        }

        return [$query, $object];
    }

    public function create(TranslationStoreRequest $request): void
    {
        $item = $this->entity->create([
            'key' => $request->input('key')
        ]);

        $this->saveEntries($request->input('entries'), $item);
        $this->syncGroups($request->input('groups'), $item);

        $this->fireStatusMessage(StatusMessage::TYPES['success'], "Translation \"$item->key\" was successfully created");
        return;
    }

    public function update(TranslationUpdateRequest $request, Translation $item): void
    {
        $item->key = $request->input('key');
        $item->save();

        $this->saveEntries($request->input('entries'), $item);
        $this->syncGroups($request->input('groups'), $item);

        $this->fireStatusMessage(StatusMessage::TYPES['success'], "Translation \"$item->key\" was successfully modified");
        return;
    }

    public function destroy(Translation $item): void
    {
        $key = $item->key;
        $item->delete();

        $this->fireStatusMessage(StatusMessage::TYPES['success'], "Translation \"$key\" was successfully deleted");
    }

    protected function saveEntries(?array $entries, Translation $translation): void
    {
        try {
            if (isset($entries) && !empty($entries))
                $this->entryService->saveFromTranslation($entries, $translation);
        } catch (Exception $exception) {
            $message = $exception->getMessage();
            $this->fireStatusMessage(StatusMessage::TYPES['danger'], "Translation entries error:\"$message\"");
        }
    }

    protected function syncGroups(?array $groups, Translation $translation): void
    {
        try {
            if (isset($groups) && !empty($groups))
                $translation->groups()->sync($groups);
        } catch (Exception $exception) {
            $message = $exception->getMessage();
            $this->fireStatusMessage(StatusMessage::TYPES['danger'], "Translation entries error:\"$message\"");
        }
    }
}
