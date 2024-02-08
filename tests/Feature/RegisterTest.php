<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;

class RegisterTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_displays_registration_form()
    {
        $response = $this->get(route('register'));
        $response->assertStatus(200);
        $response->assertViewIs('register');
    }

    public function test_registers_a_user()
    {
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password',
            'address' => $this->faker->address,
        ];
        $response = $this->post(route('signup'), $userData);
        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('users', ['email' => $userData['email']]);
    }

    public function test_validates_registration_form()
    {
        $response = $this->post(route('signup'), []);
        $response->assertSessionHasErrors(['name', 'email', 'password', 'address']);
    }

    public function test_validates_email_unique()
    {
        $user = User::factory()->create();
        $response = $this->post(route('signup'), ['email' => $user->email]);
        $response->assertSessionHasErrors(['email']);
    }
}
