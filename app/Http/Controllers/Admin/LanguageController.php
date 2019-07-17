<?php


namespace App\Http\Controllers\Admin;


use App\Entities\Languages\Language;
use App\Entities\Languages\LanguageRM;
use App\Http\Requests\Languages\LanguageSearchRequest;
use App\Http\Requests\Languages\LanguageStoreRequest;
use App\Http\Requests\Languages\LanguageUpdateRequest;
use App\Services\Languages\LanguageService;

class LanguageController extends AdminController
{
    private function getView(string $view): string
    {
        return sprintf('languages.%s', $view);
    }

    public function __construct(LanguageService $service)
    {
        $this->service = $service;
    }

    public function index(LanguageSearchRequest $request)
    {
        list($items, $queryObject) = $this->service->search($request, self::ITEMS_PER_PAGE);

        return $this->render($this->getView('languageIndex'), [
            'items' => $items,
            'searchQuery' => $queryObject,
        ]);
    }

    public function create()
    {
        return $this->render($this->getView('languageCreate'));
    }

    public function store(LanguageStoreRequest $request)
    {
        $this->service->create($request);

        return redirect()->route('admin.languages.index');
    }

    public function show(LanguageRM $language)
    {
        return $this->render($this->getView('languageShow'), [
            'item' => $language
        ]);
    }

    public function edit(LanguageRM $language)
    {
        return $this->render($this->getView('languageEdit'), [
            'item' => $language
        ]);
    }

    public function update(LanguageUpdateRequest $request, Language $language)
    {
        $this->service->update($request, $language);

        return redirect()->route('admin.languages.show', [
            'item' => $language
        ]);
    }

    public function destroy(Language $language)
    {
        $this->service->destroy($language);

        return redirect()->route('admin.languages.index');
    }
}
