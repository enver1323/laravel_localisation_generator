<?php


namespace App\Http\Controllers\Admin;


use App\Http\Requests\Translations\TranslationSearchRequest;
use App\Http\Requests\Translations\TranslationStoreRequest;
use App\Http\Requests\Translations\TranslationUpdateRequest;
use App\Models\Entities\StatusMessage;
use App\Models\Entities\Translations\Translation;
use App\Models\Repositories\Groups\GroupRepository;
use App\Models\Repositories\Languages\LanguageRepository;
use App\Models\Services\StatusMessages\StatusMessageService;
use App\Models\Services\Translations\TranslationService;
use Exception;

class TranslationController extends AdminController
{
    private $languages;
    private $groups;

    private function getView(string $view): string
    {
        return sprintf('translations.%s', $view);
    }

    public function __construct(
        LanguageRepository $languages,
        TranslationService $service,
        GroupRepository $groups,
        StatusMessageService $messageService
    )
    {
        $this->groups = $groups;
        $this->service = $service;
        $this->languages = $languages;
        $this->messageService = $messageService;
    }

    public function index(TranslationSearchRequest $request)
    {
        return $this->render($this->getView('translationIndex'), [
            'items' => $this->service->search($request, self::ITEMS_PER_PAGE),
            'langs' => $this->languages->all(),
            'groups' => $this->groups->all(),
        ]);
    }

    public function create()
    {
        return $this->render($this->getView('translationCreate'), [
            'langs' => $this->languages->all(),
            'groups' => $this->groups->all()
        ]);
    }

    public function store(TranslationStoreRequest $request)
    {
        try {
            $this->messageService->fireMessage(StatusMessage::TYPES['success'], __('adminTranslation.createSuccess', [
                'key' => $this->service->create($request)->key,
            ]));
        } catch (Exception $exception) {
            $this->messageService->fireMessage(StatusMessage::TYPES['danger'], $exception->getMessage());
        }

        return redirect()->route('admin.translations.index');
    }

    public function show(Translation $translation)
    {
        return $this->render($this->getView('translationShow'), [
            'item' => $translation
        ]);
    }

    public function edit(Translation $translation)
    {
        return $this->render($this->getView('translationEdit'), [
            'item' => $translation,
            'langs' => $this->languages->all(),
            'groups' => $this->groups->all()
        ]);
    }

    public function update(TranslationUpdateRequest $request, Translation $translation)
    {
        try {
            $this->messageService->fireMessage(StatusMessage::TYPES['success'], __('adminTranslation.updateSuccess', [
                'key' => $this->service->update($request, $translation)->key
            ]));
        } catch (Exception $exception) {
            $this->messageService->fireMessage(StatusMessage::TYPES['danger'], $exception->getMessage());
        }

        return redirect()->route('admin.translations.show', [
            'item' => $translation
        ]);
    }


    public function destroy(Translation $translation)
    {
        try {
            $this->messageService->fireMessage(StatusMessage::TYPES['success'], __('adminTranslation.destroySuccess', [
                'key' => $this->service->destroy($translation)
            ]));
        } catch (Exception $exception) {
            $this->messageService->fireMessage(StatusMessage::TYPES['danger'], $exception->getMessage());
        }

        return redirect()->route('admin.translations.index');
    }
}
