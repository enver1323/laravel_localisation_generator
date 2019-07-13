<?php


namespace App\Http\Controllers\Admin;




use App\Entites\Languages\LanguageRM;
use App\Entites\Translations\TranslationRM;
use App\Http\Requests\TranslationStoreRequest;
use App\Http\Requests\TranslationUpdateRequest;

class TranslationController extends AdminController
{
    private $translations;

    private $languages;

    const VIEW_FOLDER = 'translations';

    private function getView(string $view): string
    {
        return sprintf('%s.%s', self::VIEW_FOLDER, $view);
    }

    public function __construct(TranslationRM $translations, LanguageRM $languageRM)
    {
        $this->translations = $translations;
        $this->languages = $languageRM;
    }

    public function index()
    {
        return $this->render($this->getView('index'), [
            'items' => $this->translations->getPaginated(self::ITEMS_PER_PAGE),
            'langs' => $this->languages->getAll(),
        ]);
    }

    public function create()
    {
        return $this->render($this->getView('create'));
    }

    public function store()
    {
        /**
         * Store translation logic
         */

        $item = $this->translations;

        return redirect()->route('admin.translations.show', $item);
    }

    public function show(TranslationStoreRequest $request)
    {
        return $this->render($this->getView('create'));
    }

    public function edit(TranslationRM $translation)
    {
        return $this->render($this->getView('index'), [
            'item' => $translation
        ]);
    }

    public function update(TranslationUpdateRequest $request)
    {
        /**
         * Update translation logic
         */

        $item = $this->translations;

        return redirect()->route('admin.translations.show', $item);
    }

    public function destroy(Translation $item)
    {
        $item->remove();

        return redirect()->route('admin.translations.index');
    }
}
