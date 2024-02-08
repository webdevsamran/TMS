<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_displays_login_form()
    {
        $response = $this->get(route('login'));
        $response->assertStatus(200);
        $response->assertViewIs('login');
    }

    public function test_redirects_authenticated_user_to_dashboard()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('login'));
        $response->assertRedirect(route('dashboard'));
    }

    public function test_logs_in_user()
    {
        $user = User::factory()->create();
        $response = $this->post(route('signin'), [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_validates_login_form()
    {
        $response = $this->post(route('signin'), []);
        $response->assertSessionHasErrors(['email', 'password']);
    }

    public function test_redirects_on_failed_login()
    {
        $response = $this->post(route('signin'), [
            'email' => 'nonexistent@example.com',
            'password' => 'invalidpassword',
        ]);
        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }
}
