<?php

namespace Tests\Feature;

use App\Models\Administrator;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class AdministratorEmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_verification_screen_can_be_rendered()
    {
        $administrator = Administrator::factory()->create([
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($administrator, 'administrator')->get('administrator/verify-email');

        $response->assertStatus(200);
    }

    public function test_email_can_be_verified()
    {
        Event::fake();

        $administrator = Administrator::factory()->create([
            'email_verified_at' => null,
        ]);

        $verificationUrl = URL::temporarySignedRoute(
            'administrator.verification.verify',
            now()->addMinutes(60),
            ['id' => $administrator->id, 'hash' => sha1($administrator->email)]
        );

        $response = $this->actingAs($administrator, 'administrator')->get($verificationUrl);

        Event::assertDispatched(Verified::class);
        $this->assertTrue($administrator->fresh()->hasVerifiedEmail());
        $response->assertRedirect(route('administrator.dashboard').'?verified=1');
    }

    public function test_email_is_not_verified_with_invalid_hash()
    {
        $administrator = Administrator::factory()->create([
            'email_verified_at' => null,
        ]);

        $verificationUrl = URL::temporarySignedRoute(
            'administrator.verification.verify',
            now()->addMinutes(60),
            ['id' => $administrator->id, 'hash' => sha1('wrong-email')]
        );

        $this->actingAs($administrator, 'administrator')->get($verificationUrl);

        $this->assertFalse($administrator->fresh()->hasVerifiedEmail());
    }
}
