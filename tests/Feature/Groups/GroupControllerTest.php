<?php


namespace Tests\Feature\Groups;



use App\Models\Entities\Groups\Group;
use Illuminate\Support\Str;
use Tests\Feature\FeatureTestCase;

class GroupControllerTest extends FeatureTestCase
{
    private $entity;

    public function setUp(): void
    {
        parent::setUp();
        $this->entity = factory(Group::class)->create();
    }

    public function testIndex(): void
    {
        $route = route('admin.groups.index');
        parent::logout();
        parent::checkLoginRedirect('get', $route);
        parent::authenticate();

        $this->get($route)
            ->assertOk()
            ->assertViewIs('admin.groups.groupIndex');

        $this->searchTest(true);

    }

    private function searchTest(bool $testAll = true, string $name = null): void
    {
        $route = route('admin.groups.index');
        $item = ($testAll || isset($name)) ? $this->entity : (object)['name' => $name];

        $this->call('get', $route, ['id' => $item->id])
            ->assertViewIs('admin.groups.groupIndex');

        $this->call('get', $route, ['name' => $item->name])
            ->assertViewIs('admin.groups.groupIndex');
    }

    public function testStore(): void
    {
        $route = route('admin.groups.store');

        parent::checkLoginRedirect('post', $route);
        parent::authenticate();

        $this->post($route, [
            'name' => Str::uuid()->toString(),
            'description' => Str::uuid()->toString()
        ])->assertRedirect(route('admin.groups.index'));
    }

    public function testUpdate(): void
    {
        $route = route('admin.groups.update', $this->entity);

        parent::authenticate();

        $this->patch($route, [
            'name' => Str::uuid()->toString(),
            'description' => Str::uuid()->toString()
        ])->assertRedirect(route('admin.groups.show', $this->entity));
    }

    public function testShow(): void
    {
        $route = route('admin.groups.show', $this->entity);

        parent::logout();
        parent::checkLoginRedirect('get', $route);

        parent::authenticate();
        parent::checkView('get', $route, 'admin.groups.groupShow');
    }

    public function testEdit(): void
    {
        $route = route('admin.groups.edit', $this->entity);
        parent::logout();
        parent::checkLoginRedirect('get', $route);

        parent::authenticate();
        parent::checkView('get', $route, 'admin.groups.groupEdit');
    }

    public function testDestroy(): void
    {
        $route = route('admin.groups.destroy', $this->entity->id);

        parent::authenticate();

        $this->delete($route)->assertRedirect(route('admin.groups.index'));
    }
}
