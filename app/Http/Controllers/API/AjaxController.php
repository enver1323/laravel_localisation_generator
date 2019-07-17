<?php


namespace App\Http\Controllers\API;


use App\Http\Requests\Groups\GroupSearchRequest;
use App\Http\Requests\Translations\TranslationSearchRequest;
use App\Http\Resources\Groups\GroupResource;
use App\Http\Resources\Translations\TranslationResource;
use App\Services\Groups\GroupService;
use App\Services\Translations\TranslationService;

class AjaxController extends APIController
{
    private $translationService;
    private $groupService;

    public function __construct(TranslationService $translationService, GroupService $groupService)
    {
        $this->translationService = $translationService;
        $this->groupService = $groupService;
    }

    public function getTranslations(TranslationSearchRequest $request)
    {
        list($items, $objectQuery) = $this->translationService->search($request, 5);

        return $this->render(TranslationResource::collection($items));
    }

    public function getGroups(GroupSearchRequest $request)
    {
        list($items, $objectQuery) = $this->groupService->search($request, 5);

        return $this->render(GroupResource::collection($items));
    }
}
