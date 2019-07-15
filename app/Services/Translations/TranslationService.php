<?php


namespace App\Services\Translations;


use App\Entities\StatusMessage;
use App\Entities\Translations\Translation;
use App\Entities\Translations\TranslationRM;
use App\Http\Requests\Translations\TranslationSearchRequest;
use App\Http\Requests\Translations\TranslationStoreRequest;
use App\Http\Requests\Translations\TranslationUpdateRequest;
use App\Services\CustomService;
use Illuminate\Database\Query\Builder;

class TranslationService extends CustomService
{
    private $model;
    private $entity;

    public function __construct(Translation $entity, TranslationRM $model)
    {
        $this->model = $model;
        $this->entity = $entity;
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
                    $query->where('code', '=', $language->code);
                });
        }

        if (!$query->count()) {
            $query = $this->model;
            $this->fireStatusMessage(StatusMessage::TYPES['warning'], 'Nothing was found according to your query');
        }

        return [$query, $object];
    }

    public function create(TranslationStoreRequest $request): void
    {
        $item = $this->entity->create([
            'key' => $request->input('key')
        ]);

        $this->fireStatusMessage(StatusMessage::TYPES['success'], "Translation \"$item->key\" was successfully created");
        return;
    }

    public function update(TranslationUpdateRequest $request, Translation $item): void
    {
        $item->key = $request->input('key');
        $item->save();

        $this->fireStatusMessage(StatusMessage::TYPES['success'], "Translation \"$item->key\" was successfully modified");
        return;
    }

    public function destroy(Translation $item): void
    {
        $key = $item->key;
        $item->delete();

        $this->fireStatusMessage(StatusMessage::TYPES['success'], "Translation \"$key\" was successfully deleted");
    }
}
