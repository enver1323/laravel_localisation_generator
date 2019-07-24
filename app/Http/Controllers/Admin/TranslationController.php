<?php


namespace App\Http\Controllers\Admin;




use App\Entities\Groups\GroupRM;
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
    private $groups;

    private function getView(string $view): string
    {
        return sprintf('translations.%s', $view);
    }

    public function __construct(LanguageRM $languages, TranslationService $service, GroupRM $groups)
    {
        $this->groups = $groups;
        $this->service = $service;
        $this->languages = $languages;
    }

    public function index(TranslationSearchRequest $request)
    {
        list($items, $queryObject) = $this->service->search($request, self::ITEMS_PER_PAGE);

        return $this->render($this->getView('translationIndex'), [
            'items' => $items,
            'langs' => $this->languages->getAll(),
            'groups' => $this->groups->getAll(),
            'searchQuery' => $queryObject
        ]);
    }

    public function create()
    {
        return $this->render($this->getView('translationCreate'), [
            'langs' => $this->languages->getAll(),
            'groups' => $this->groups->getAll()
        ]);
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
            'item' => $translation,
            'langs' => $this->languages->getAll(),
            'groups' => $this->groups->getAll()
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
