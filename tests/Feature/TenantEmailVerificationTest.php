<?php

namespace Tests\Feature;

use App\Models\Tenant;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class TenantEmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_verification_screen_can_be_rendered()
    {
        $tenant = Tenant::factory()->create([
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($tenant, 'tenant')->get('tenant/verify-email');

        $response->assertStatus(200);
    }

    public function test_email_can_be_verified()
    {
        Event::fake();

        $tenant = Tenant::factory()->create([
            'email_verified_at' => null,
        ]);

        $verificationUrl = URL::temporarySignedRoute(
            'tenant.verification.verify',
            now()->addMinutes(60),
            ['id' => $tenant->id, 'hash' => sha1($tenant->email)]
        );

        $response = $this->actingAs($tenant, 'tenant')->get($verificationUrl);

        Event::assertDispatched(Verified::class);
        $this->assertTrue($tenant->fresh()->hasVerifiedEmail());
        $response->assertRedirect(route('tenant.dashboard').'?verified=1');
    }

    public function test_email_is_not_verified_with_invalid_hash()
    {
        $tenant = Tenant::factory()->create([
            'email_verified_at' => null,
        ]);

        $verificationUrl = URL::temporarySignedRoute(
            'tenant.verification.verify',
            now()->addMinutes(60),
            ['id' => $tenant->id, 'hash' => sha1('wrong-email')]
        );

        $this->actingAs($tenant, 'tenant')->get($verificationUrl);

        $this->assertFalse($tenant->fresh()->hasVerifiedEmail());
    }
}
