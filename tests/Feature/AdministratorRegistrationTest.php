<?php

namespace Tests\Feature;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdministratorRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get('administrator/register');

        $response->assertStatus(200);
    }

    public function test_new_administrators_can_register()
    {
        $response = $this->post('administrator/register', [
            'name' => 'Test Administrator',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated('administrator');
        $response->assertRedirect(route('administrator.dashboard'));
    }
}
