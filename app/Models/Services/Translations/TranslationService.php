<?php


namespace App\Models\Services\Translations;

use App\Models\Entities\Translations\Translation;
use App\Http\Requests\Translations\TranslationSearchRequest;
use App\Http\Requests\Translations\TranslationStoreRequest;
use App\Http\Requests\Translations\TranslationUpdateRequest;
use App\Models\Repositories\Translations\TranslationRepository;
use App\Models\Services\CustomService;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Throwable;

class TranslationService extends CustomService
{
    /**
     * @var TranslationRepository
     */
    private $translations;
    /**
     * @var TranslationEntryService
     */
    private $entryService;

    public function __construct(TranslationRepository $translations, TranslationEntryService $entryService)
    {
        $this->translations = $translations;
        $this->entryService = $entryService;
    }

    public function search(TranslationSearchRequest $request, int $itemsPerPage): LengthAwarePaginator
    {
        if (!empty($request->validated()))
            return $this->translations->formSearch($request, $itemsPerPage);

        return $this->translations->paginate($itemsPerPage);
    }

    /**
     * @param TranslationStoreRequest $request
     * @return Translation
     * @throws Throwable
     */
    public function create(TranslationStoreRequest $request): Translation
    {
        $item = $this->translations->create($request->key);

        $this->translations->saveEntries($item, $request->entries);
        $this->translations->syncGroups($item, $request->groups);

        return $item;
    }

    /**
     * @param TranslationUpdateRequest $request
     * @param Translation $item
     * @return Translation
     * @throws Throwable
     */
    public function update(TranslationUpdateRequest $request, Translation $item): Translation
    {
        $item->key = $request->input('key');
        $this->translations->save($item);

        $this->translations->saveEntries($item, $request->entries);
        $this->translations->syncGroups($item, $request->groups);

        return $item;
    }

    /**
     * @param Translation $item
     * @return string
     * @throws Exception
     */
    public function destroy(Translation $item): string
    {
        $key = $item->key;
        $this->translations->delete($item);

        return $key;
    }
}
