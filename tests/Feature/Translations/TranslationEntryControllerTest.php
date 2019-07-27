<?php


namespace Tests\Feature\Translations;


use App\Models\Entities\Languages\Language;
use App\Models\Entities\Translations\Translation;
use Illuminate\Support\Str;
use Tests\Feature\FeatureTestCase;

class TranslationEntryControllerTest extends FeatureTestCase
{
    private $translationEntity;
    private $languageEntity;

    public function setUp(): void
    {
        parent::setUp();
        $this->translationEntity = factory(Translation::class)->create();
        $this->languageEntity = factory(Language::class)->create();
    }

    public function testStore()
    {
        $route = route('admin.translations.store');

        parent::checkLoginRedirect('post', $route);
        parent::authenticate();

        $key = Str::uuid();
        $this->followingRedirects()
            ->post($route, [
                'key' => $key,
                'translations' => [$this->languageEntity->code => $key]
            ])->assertOk();
    }

    public function testUpdate()
    {
        $route = route('admin.translations.update', $this->translationEntity);

        parent::authenticate();

        $key = Str::uuid();
        $this->followingRedirects()
            ->patch($route, ['key' => $key])
            ->assertOk();
    }
}
