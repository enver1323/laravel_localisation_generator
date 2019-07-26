<?php


namespace App\Models\Repositories\Translations;


use App\Models\Entities\Translations\Entries\TranslationEntry;
use App\Models\Repositories\CustomRepository;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Throwable;

class TranslationEntryRepository extends CustomRepository
{
    /**
     * @var TranslationEntry
     */
    private $entity;

    public function __construct(TranslationEntry $entity)
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
     * @return TranslationEntry|Collection
     */
    public function find($item)
    {
        return $this->entity->findOrFail($item);
    }

    /**
     * @param int $translation_id
     * @param string $language_code
     * @param string $entry
     * @return TranslationEntry
     */
    public function getEntity(int $translation_id = null, string $language_code = null, string $entry = null): TranslationEntry
    {
        $item = new $this->entity();

        $item->translation_id = $translation_id;
        $item->language_code = $language_code;
        $item->entry = $entry;

        return $item;
    }

    /**
     * @param TranslationEntry $item
     * @return bool
     * @throws Throwable
     */
    public function save(TranslationEntry $item): bool
    {
        return $item->saveOrFail();
    }

    /**
     * @param int $translation_id
     * @param string $language_code
     * @param string $entry
     * @return TranslationEntry
     * @throws Throwable
     */
    public function create(int $translation_id, string $language_code, string $entry): TranslationEntry
    {
        $item = $this->getEntity();
        $item->entry = $entry;
        $item->language_code = $language_code;
        $item->translation_id = $translation_id;

        $this->save($item);

        return $item;
    }


    public function getByParams(int $translation_id, string $language_code): TranslationEntry
    {
        $item = $this->entity->where('translation_id', $translation_id)
                ->where('language_code', $language_code)
                ->first() ?? $this->getEntity();

        $item->language_code = $language_code;
        $item->translation_id = $translation_id;

        return $item;
    }

    /**
     * @param TranslationEntry $item
     * @throws Exception
     */
    public function delete(TranslationEntry $item): void
    {
        $item->delete();
    }
}
