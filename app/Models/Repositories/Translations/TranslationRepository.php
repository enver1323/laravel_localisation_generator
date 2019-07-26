<?php


namespace App\Models\Repositories\Translations;


use App\Http\Requests\Translations\TranslationSearchRequest;
use App\Models\Entities\Translations\Translation;
use App\Models\Repositories\CustomRepository;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Throwable;

class TranslationRepository extends CustomRepository
{
    /**
     * @var Translation
     */
    private $entity;
    /**
     * @var TranslationEntryRepository
     */
    private $entries;

    public function __construct(Translation $entity, TranslationEntryRepository $entries)
    {
        $this->entity = $entity;
        $this->entries = $entries;
    }

    /**
     * @return Collection|null
     */
    public function all(): ?Collection
    {
        return $this->entity->all();
    }

    /**
     * @param int $itemsPerPage
     * @return LengthAwarePaginator
     */
    public function paginate(int $itemsPerPage): LengthAwarePaginator
    {
        return $this->entity->paginate($itemsPerPage);
    }

    /**
     * @param $item
     * @return Translation|Collection
     */
    public function find($item)
    {
        return $this->entity->findOrFail($item);
    }

    /**
     * @param string|null $key
     * @return Translation
     */
    public function getEntity(string $key = null): Translation
    {
        $item = new $this->entity();

        $item->key = $key;

        return $item;
    }

    /**
     * @param Translation $item
     * @return bool
     * @throws Throwable
     */
    public function save(Translation $item): bool
    {
        return $item->saveOrFail();
    }

    /**
     * @param string $key
     * @return Translation
     * @throws Throwable
     */
    public function create(string $key): Translation
    {
        $item = $this->getEntity($key);

        $this->save($item);

        return $item;
    }

    /**
     * @param Translation $item
     * @throws Exception
     */
    public function delete(Translation $item): void
    {
        $item->delete();
    }

    /**
     * @param TranslationSearchRequest $request
     * @param int $itemsPerPage
     * @return LengthAwarePaginator
     */
    public function formSearch(TranslationSearchRequest $request, int $itemsPerPage): LengthAwarePaginator
    {
        $query = $this->entity;

        if ($request->input('id'))
            $query = $query->where('id', '=', $request->input('id'));

        if ($request->key)
            $query = $query->where('key', 'LIKE', "%$request->key%");

        if ($request->languages && !empty($request->languages))
            foreach ($request->languages as $language)
                $query = $query->whereHas('languages', function (Builder $query) use ($language) {
                    $query->where('code', '=', $language);
                });

        if ($request->groups && !empty($request->groups))
            foreach ($request->groups as $group)
                $query = $this->entity->whereHas('groups', function (Builder $query) use ($group) {
                    $query->where('id', '=', $group);
                });

        return $query->paginate($itemsPerPage);
    }

    public function saveEntries(Translation $translation, ?array $entries = []): void
    {
        $list = [];

        foreach ($entries as $key => $entry){
            $item = $this->entries->getByParams($translation->id, $key);
            $item->entry = $entry;

            $list[] = $item;
        }

        $translation->entries()->saveMany($list);
    }

    public function syncGroups(Translation $translation, ?array $groups): void
    {
        $translation->groups()->sync($groups);
    }
}
