<?php

namespace Tests\Feature;

use App\Models\Tenant;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class TenantPasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_reset_password_link_screen_can_be_rendered()
    {
        $response = $this->get('tenant/forgot-password');

        $response->assertStatus(200);
    }

    public function test_reset_password_link_can_be_requested()
    {
        Notification::fake();

        $tenant = Tenant::factory()->create();

        $response = $this->post('tenant/forgot-password', [
            'email' => $tenant->email,
        ]);

        Notification::assertSentTo($tenant, ResetPassword::class);
    }

    public function test_reset_password_screen_can_be_rendered()
    {
        Notification::fake();

        $tenant = Tenant::factory()->create();

        $response = $this->post('tenant/forgot-password', [
            'email' => $tenant->email,
        ]);

        Notification::assertSentTo($tenant, ResetPassword::class, function ($notification) {
            $response = $this->get('tenant/reset-password/'.$notification->token);

            $response->assertStatus(200);

            return true;
        });
    }

    public function test_password_can_be_reset_with_valid_token()
    {
        Notification::fake();

        $tenant = Tenant::factory()->create();

        $response = $this->post('tenant/forgot-password', [
            'email' => $tenant->email,
        ]);

        Notification::assertSentTo($tenant, ResetPassword::class, function ($notification) use ($tenant) {
            $response = $this->post('tenant/reset-password', [
                'token' => $notification->token,
                'email' => $tenant->email,
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);

            $response->assertSessionHasNoErrors();

            return true;
        });
    }
}
