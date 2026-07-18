<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_access_login_page_after_logout(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'is_active' => true,
        ]);

        $this->actingAs($user);

        $this->post(route('logout'))->assertRedirect('/');

        $this->assertGuest();
        $this->get(route('login'))->assertOk();
    }

    public function test_authenticated_user_is_redirected_from_login_page_to_dashboard(): void
    {
        $user = User::factory()->create([
            'email' => 'staff@example.com',
            'is_active' => true,
        ]);

        $this->actingAs($user);

        $this->get(route('login'))->assertRedirect(route('admin.dashboard'));
    }

}
