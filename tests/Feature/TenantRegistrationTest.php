<?php

namespace Tests\Feature;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TenantRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get('tenant/register');

        $response->assertStatus(200);
    }

    public function test_new_tenants_can_register()
    {
        $response = $this->post('tenant/register', [
            'name' => 'Test Tenant',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated('tenant');
        $response->assertRedirect(route('tenant.dashboard'));
    }
}
