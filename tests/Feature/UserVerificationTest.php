<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\Models\User;

class UserVerificationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_redirects_unauthenticated_user_to_login()
    {
        $response = $this->get(route('dashboard'));
        $response->assertRedirect(route('login'));
    }

    public function test_allows_authenticated_user_to_access_dashboard()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('dashboard'));
        $response->assertStatus(200);
        $response->assertViewIs('dashboard.dashboard');
    }

    public function test_allows_authenticated_user_to_logout()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('logout'));
        $response->assertRedirect('/');
        $this->assertGuest();
    }
}
