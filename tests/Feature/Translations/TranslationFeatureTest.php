<?php


namespace Tests\Feature\Translations;



use App\Entities\Translations\Translation;
use Illuminate\Support\Str;
use Tests\Feature\FeatureTestCase;

class TranslationFeatureTest extends FeatureTestCase
{
    private $entity;

    public function setUp(): void
    {
        parent::setUp();
        $this->entity = factory(Translation::class)->create();
    }

    public function testIndex()
    {
        $route = route('admin.translations.index');

        parent::checkWebAuth('get', $route);
        parent::authenticate();

        $this->get($route)->assertOk();
//        $this->checkView('get', $route, 'admin.translations.translationIndex');
//        $this->searchTest(true);
    }

    private function searchTest(bool $testAll, string $key = null)
    {
        $route = route('admin.translations.index');
        $item = ($testAll || isset($key)) ? $this->entity : (object)['key' => $key];

        $this->call('get', $route, [
            'id' => $item->id
        ])->assertSee('results were found');
        $this->call('get', $route, [
            'key' => $item->key
        ])->assertSee('results were found');
    }

    public function testStore()
    {
        $route = route('admin.translations.store');

        parent::checkWebAuth('post', $route);
        parent::authenticate();

        $key = Str::uuid();
        $this->post($route, [
            'key' => $key
        ]);
        $this->searchTest(false, $key);
    }

    public function testUpdate()
    {
        $route = route('admin.translations.update', $this->entity);

        parent::authenticate();

        $key = Str::uuid();
        $this->post($route, [
            'key' => $key
        ]);
        $this->searchTest(false, $key);
    }

    public function testShow()
    {
        $route = route('admin.translations.show', $this->entity);

        parent::authenticate();
//        parent::checkView('get', $route, 'admin.translations.translationShow');
    }

    public function testEdit()
    {
        $route = route('admin.translations.edit', $this->entity);

        parent::authenticate();
//        parent::checkView('get', $route, 'admin.translations.translationEdit');
    }

    public function testDestroy()
    {
        $route = route('admin.translations.destroy', $this->entity->id);

        parent::authenticate();

        $this->delete($route)->assertRedirect(route('admin.translations.index'));
    }
}
