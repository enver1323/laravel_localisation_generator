<?php


namespace App\Models\Repositories\Languages;


use App\Http\Requests\Languages\LanguageSearchRequest;
use App\Models\Entities\Languages\Language;
use App\Models\Repositories\CustomRepository;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Throwable;

class LanguageRepository extends CustomRepository
{
    private $entity;

    public function __construct(Language $entity)
    {
        $this->entity = $entity;
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
     * @return Language|Collection
     */
    public function find($item)
    {
        return $this->entity->findOrFail($item);
    }

    /**
     * @param string|null $code
     * @param string|null $name
     * @return Language
     */
    public function getEntity(string $code = null, string $name = null): Language
    {
        $item = new $this->entity();

        $item->code = $code;
        $item->name = $name;

        return $item;
    }

    /**
     * @param Language $item
     * @return bool
     * @throws Throwable
     */
    public function save(Language $item): bool
    {
        return $item->saveOrFail();
    }

    /**
     * @param string $code
     * @param string $name
     * @return Language
     * @throws Throwable
     */
    public function create(string $code, string $name): Language
    {
        $item = $this->getEntity($code, $name);

        $this->save($item);

        return $item;
    }

    /**
     * @param Language $item
     * @throws Exception
     */
    public function delete(Language $item): void
    {
        $item->delete();
    }

    /**
     * @param LanguageSearchRequest $request
     * @param int $itemsPerPage
     * @return LengthAwarePaginator
     */
    public function formSearch(LanguageSearchRequest $request, int $itemsPerPage): LengthAwarePaginator
    {
        $query = $this->entity;

        if ($request->code)
            $query = $query->where('code', '=', $request->code);

        if ($request->name)
            $query = $query->where('name', 'LIKE', "%$request->name%");

        return $query->paginate($itemsPerPage);
    }
}
