<?php


namespace App\Http\Controllers\Admin;


use App\Http\Requests\Languages\LanguageSearchRequest;
use App\Http\Requests\Languages\LanguageStoreRequest;
use App\Http\Requests\Languages\LanguageUpdateRequest;
use App\Models\Entities\Languages\Language;
use App\Models\Entities\StatusMessage;
use App\Models\Services\Languages\LanguageService;
use App\Models\Services\StatusMessages\StatusMessageService;
use Exception;

class LanguageController extends AdminController
{
    private function getView(string $view): string
    {
        return sprintf('languages.%s', $view);
    }

    public function __construct(LanguageService $service, StatusMessageService $messageService)
    {
        $this->service = $service;
        $this->messageService = $messageService;
    }

    public function index(LanguageSearchRequest $request)
    {
        return $this->render($this->getView('languageIndex'), [
            'items' => $this->service->search($request, self::ITEMS_PER_PAGE),
        ]);
    }

    public function create()
    {
        return $this->render($this->getView('languageCreate'));
    }

    public function store(LanguageStoreRequest $request)
    {
        try {
            $this->messageService->fireMessage(StatusMessage::TYPES['success'], __('adminLanguage.createSuccess', [
                'name' => $this->service->create($request)->name
            ]));
        } catch (Exception $exception) {
            $this->messageService->fireMessage(StatusMessage::TYPES['danger'], $exception->getMessage());
        }

        return redirect()->route('admin.languages.index');
    }

    public function show(Language $language)
    {
        return $this->render($this->getView('languageShow'), [
            'item' => $language
        ]);
    }

    public function edit(Language $language)
    {
        return $this->render($this->getView('languageEdit'), [
            'item' => $language
        ]);
    }

    public function update(LanguageUpdateRequest $request, Language $language)
    {
        try {
            $this->messageService->fireMessage(StatusMessage::TYPES['success'], __('adminLanguage.updateSuccess', [
                'name' => $this->service->update($request, $language)->name
            ]));
        } catch (Exception $exception) {
            $this->messageService->fireMessage(StatusMessage::TYPES['danger'], $exception->getMessage());
        }

        return redirect()->route('admin.languages.show', [
            'item' => $language
        ]);
    }

    public function destroy(Language $language)
    {
        try {
            $this->messageService->fireMessage(StatusMessage::TYPES['success'], __('adminLanguage.destroySuccess', [
                'name' => $this->service->destroy($language)
            ]));
        } catch (Exception $exception) {
            $this->messageService->fireMessage(StatusMessage::TYPES['danger'], $exception->getMessage());
        }

        return redirect()->route('admin.languages.index');
    }
}
