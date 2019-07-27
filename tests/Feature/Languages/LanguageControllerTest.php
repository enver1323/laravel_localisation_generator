<?php


namespace Tests\Feature\Languages;


use App\Models\Entities\Languages\Language;
use Illuminate\Support\Str;
use Tests\Feature\FeatureTestCase;

class LanguageControllerTest extends FeatureTestCase
{
    private $entity;

    public function setUp(): void
    {
        parent::setUp();
        $this->entity = factory(Language::class)->create();
    }

    public function testIndex(): void
    {
        $route = route('admin.languages.index');
        parent::logout();
        parent::checkLoginRedirect('get', $route);
        parent::authenticate();

        $this->get($route)
            ->assertOk()
            ->assertViewIs('admin.languages.languageIndex');

        $this->searchTest(true);
    }

    private function searchTest(bool $testAll = true, string $code = null, string $name = null): void
    {
        $route = route('admin.languages.index');
        $item = ($testAll || isset($code)) ? $this->entity : (object)['code' => $code, 'name' => $name];

        $this->call('get', $route, ['code' => $item->code])
            ->assertViewIs('admin.languages.languageIndex')
            ->assertOk();

        $this->call('get', $route, ['name' => $item->name])
            ->assertViewIs('admin.languages.languageIndex')
            ->assertOk();
    }

    public function testStore(): void
    {
        $route = route('admin.languages.store');

        parent::checkLoginRedirect('post', $route);
        parent::authenticate();

        $this->post($route, ['code' => 'en', 'name' => 'English'])
            ->assertRedirect(route('admin.languages.index'));
    }

    public function testUpdate(): void
    {
        $route = route('admin.languages.update', $this->entity);

        parent::authenticate();

        $this->patch($route, ['name' => Str::uuid()->toString()])
            ->assertRedirect(route('admin.languages.show', $this->entity));
    }

    public function testShow(): void
    {
        $route = route('admin.languages.show', $this->entity);

        parent::logout();
        parent::checkLoginRedirect('get', $route);

        parent::authenticate();
        parent::checkView('get', $route, 'admin.languages.languageShow');
    }

    public function testEdit(): void
    {
        $route = route('admin.languages.edit', $this->entity);
        parent::logout();
        parent::checkLoginRedirect('get', $route);

        parent::authenticate();
        parent::checkView('get', $route, 'admin.languages.languageEdit');
    }

    public function testDestroy(): void
    {
        $route = route('admin.languages.destroy', $this->entity);

        parent::authenticate();

        $this->delete($route)->assertRedirect(route('admin.languages.index'));
    }
}
