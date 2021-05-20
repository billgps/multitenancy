<?php

namespace Tests\Feature;

use App\Models\Tenant;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TenantAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('tenant/login');

        $response->assertStatus(200);
    }

    public function test_tenants_can_authenticate_using_the_login_screen()
    {
        $tenant = Tenant::factory()->create();

        $response = $this->post('tenant/login', [
            'email' => $tenant->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated('tenant');
        $response->assertRedirect(route('tenant.dashboard'));
    }

    public function test_tenants_can_not_authenticate_with_invalid_password()
    {
        $tenant = Tenant::factory()->create();

        $this->post('tenant/login', [
            'email' => $tenant->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest('tenant');
    }
}
