<?php


namespace Tests\Feature;


use App\Models\Entities\Users\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class FeatureTestCase extends TestCase
{
    use DatabaseMigrations;

    protected function authenticate(): void
    {
        $this->actingAs(factory(User::class)->make());
    }

    protected function logout(): void
    {
        Auth::logout();
    }

    protected function checkLoginRedirect(string $method, string $route, array $params = []): void
    {
        $this->call($method, $route, $params)->assertRedirect(route('login'));
    }

    protected function checkView(string $method, string $route, string $view): void
    {
        $this->call($method, $route)->assertViewIs($view);
    }
}
