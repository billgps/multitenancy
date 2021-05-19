<?php

namespace Tests\Feature;

use App\Models\Administrator;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdministratorAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('administrator/login');

        $response->assertStatus(200);
    }

    public function test_administrators_can_authenticate_using_the_login_screen()
    {
        $administrator = Administrator::factory()->create();

        $response = $this->post('administrator/login', [
            'email' => $administrator->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated('administrator');
        $response->assertRedirect(route('administrator.dashboard'));
    }

    public function test_administrators_can_not_authenticate_with_invalid_password()
    {
        $administrator = Administrator::factory()->create();

        $this->post('administrator/login', [
            'email' => $administrator->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest('administrator');
    }
}
