<?php

namespace Tests\Feature;

use App\Models\Administrator;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AdministratorPasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_reset_password_link_screen_can_be_rendered()
    {
        $response = $this->get('administrator/forgot-password');

        $response->assertStatus(200);
    }

    public function test_reset_password_link_can_be_requested()
    {
        Notification::fake();

        $administrator = Administrator::factory()->create();

        $response = $this->post('administrator/forgot-password', [
            'email' => $administrator->email,
        ]);

        Notification::assertSentTo($administrator, ResetPassword::class);
    }

    public function test_reset_password_screen_can_be_rendered()
    {
        Notification::fake();

        $administrator = Administrator::factory()->create();

        $response = $this->post('administrator/forgot-password', [
            'email' => $administrator->email,
        ]);

        Notification::assertSentTo($administrator, ResetPassword::class, function ($notification) {
            $response = $this->get('administrator/reset-password/'.$notification->token);

            $response->assertStatus(200);

            return true;
        });
    }

    public function test_password_can_be_reset_with_valid_token()
    {
        Notification::fake();

        $administrator = Administrator::factory()->create();

        $response = $this->post('administrator/forgot-password', [
            'email' => $administrator->email,
        ]);

        Notification::assertSentTo($administrator, ResetPassword::class, function ($notification) use ($administrator) {
            $response = $this->post('administrator/reset-password', [
                'token' => $notification->token,
                'email' => $administrator->email,
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);

            $response->assertSessionHasNoErrors();

            return true;
        });
    }
}
