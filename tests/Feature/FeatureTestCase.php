<?php


namespace Tests\Feature;


use App\Entities\Users\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class FeatureTestCase extends TestCase
{
    use DatabaseTransactions;

    protected function authenticate(): void
    {
        $this->actingAs(factory(User::class)->make());
    }

    protected function checkWebAuth(string $method, string $route, array $params = []): void
    {
        $this->call($method, $route, $params)->assertRedirect(route('login'));
    }

    protected function checkView(string $method, string $route, string $view): void
    {
        $this->call($method, $route)->assertViewIs(view($view));
    }
}
