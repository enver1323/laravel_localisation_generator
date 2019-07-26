<?php


namespace App\Models\Services\Languages;


use App\Models\Entities\Languages\Language;
use App\Http\Requests\Languages\LanguageSearchRequest;
use App\Http\Requests\Languages\LanguageStoreRequest;
use App\Http\Requests\Languages\LanguageUpdateRequest;
use App\Models\Repositories\Languages\LanguageRepository;
use App\Models\Services\CustomService;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Throwable;

class LanguageService extends CustomService
{
    /**
     * @var LanguageRepository
     */
    private $languages;

    public function __construct(LanguageRepository $languages)
    {
        $this->languages = $languages;
    }

    /**
     * @param LanguageSearchRequest $request
     * @param int $itemsPerPage
     * @return LengthAwarePaginator
     */
    public function search(LanguageSearchRequest $request, int $itemsPerPage): LengthAwarePaginator
    {
        if (!empty($request->validated()))
            return $this->languages->formSearch($request, $itemsPerPage);

        return $this->languages->paginate($itemsPerPage);
    }

    /**
     * @param LanguageStoreRequest $request
     * @return Language
     * @throws Throwable
     */
    public function create(LanguageStoreRequest $request): Language
    {
        $item = $this->languages->create($request->code, $request->name);

        return $item;
    }

    /**
     * @param LanguageUpdateRequest $request
     * @param Language $item
     * @return Language
     * @throws Throwable
     */
    public function update(LanguageUpdateRequest $request, Language $item): Language
    {
        $item->name = $request->name;
        $this->languages->save($item);

        return $item;
    }

    /**
     * @param Language $item
     * @return string
     * @throws Exception
     */
    public function destroy(Language $item): string
    {
        $name = $item->name;
        $this->languages->delete($item);

        return $name;
    }
}
