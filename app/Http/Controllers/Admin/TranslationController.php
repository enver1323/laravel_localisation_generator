<?php


namespace App\Http\Controllers\Admin;




use App\Entities\Languages\LanguageRM;
use App\Entities\Translations\Translation;
use App\Entities\Translations\TranslationRM;
use App\Http\Requests\Translations\TranslationSearchRequest;
use App\Http\Requests\Translations\TranslationStoreRequest;
use App\Http\Requests\Translations\TranslationUpdateRequest;
use App\Services\Translations\TranslationService;

class TranslationController extends AdminController
{
    private $languages;

    private function getView(string $view): string
    {
        return sprintf('translations.%s', $view);
    }

    public function __construct(LanguageRM $languages, TranslationService $service)
    {
        $this->service = $service;
        $this->languages = $languages;
    }

    public function index(TranslationSearchRequest $request)
    {
        list($items, $queryObject) = $this->service->search($request, self::ITEMS_PER_PAGE);

        return $this->render($this->getView('translationIndex'), [
            'items' => $items->appends($request->input()),
            'langs' => $this->languages->getAll(),
            'searchQuery' => $queryObject
        ]);
    }

    public function create()
    {
        return $this->render($this->getView('translationCreate'));
    }

    public function store(TranslationStoreRequest $request)
    {
        $this->service->create($request);

        return redirect()->route('admin.translations.index');
    }

    public function show(TranslationRM $translation)
    {
        return $this->render($this->getView('translationShow'), [
            'item' => $translation
        ]);
    }

    public function edit(TranslationRM $translation)
    {
        return $this->render($this->getView('translationEdit'), [
            'item' => $translation
        ]);
    }

    public function update(TranslationUpdateRequest $request, Translation $translation)
    {
        $this->service->update($request, $translation);

        return redirect()->route('admin.translations.show', [
            'item' => $translation
        ]);
    }

    public function destroy(Translation $translation)
    {
        $this->service->destroy($translation);

        return redirect()->route('admin.translations.index');
    }
}
