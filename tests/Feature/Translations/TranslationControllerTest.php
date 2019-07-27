<?php


namespace Tests\Feature\Translations;


use App\Models\Entities\Translations\Translation;
use Illuminate\Support\Str;
use Tests\Feature\FeatureTestCase;

class TranslationControllerTest extends FeatureTestCase
{
    private $entity;

    public function setUp(): void
    {
        parent::setUp();
        $this->entity = factory(Translation::class)->create();
    }

    public function testIndex(): void
    {
        $route = route('admin.translations.index');
        parent::logout();
        parent::checkLoginRedirect('get', $route);
        parent::authenticate();

        $this->get($route)
            ->assertOk()
            ->assertViewIs('admin.translations.translationIndex');

        $this->searchTest(true);

    }

    private function searchTest(bool $testAll = true, string $key = null): void
    {
        $route = route('admin.translations.index');
        $item = ($testAll || isset($key)) ? $this->entity : (object)['key' => $key];

        $this->call('get', $route, ['id' => $item->id])
            ->assertViewIs('admin.translations.translationIndex');

        $this->call('get', $route, ['key' => $item->key])
            ->assertViewIs('admin.translations.translationIndex');
    }

    public function testStore(): void
    {
        $route = route('admin.translations.store');

        parent::checkLoginRedirect('post', $route);
        parent::authenticate();

        $this->post($route, ['key' => Str::uuid()->toString()])
            ->assertRedirect(route('admin.translations.index'));
    }

    public function testUpdate(): void
    {
        $route = route('admin.translations.update', $this->entity);

        parent::authenticate();

        $this->patch($route, ['key' => Str::uuid()->toString()])
            ->assertRedirect(route('admin.translations.show', $this->entity));
    }

    public function testShow(): void
    {
        $route = route('admin.translations.show', $this->entity);

        parent::logout();
        parent::checkLoginRedirect('get', $route);

        parent::authenticate();
        parent::checkView('get', $route, 'admin.translations.translationShow');
    }

    public function testEdit(): void
    {
        $route = route('admin.translations.edit', $this->entity);
        parent::logout();
        parent::checkLoginRedirect('get', $route);

        parent::authenticate();
        parent::checkView('get', $route, 'admin.translations.translationEdit');
    }

    public function testDestroy(): void
    {
        $route = route('admin.translations.destroy', $this->entity->id);

        parent::authenticate();

        $this->delete($route)->assertRedirect(route('admin.translations.index'));
    }
}
