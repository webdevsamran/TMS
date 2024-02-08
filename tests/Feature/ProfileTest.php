<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class ProfileTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_allows_authenticated_user_to_access_profile_page()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('profile'));
        $response->assertStatus(200);
    }

    public function test_does_not_allow_non_authenticated_user_to_access_profile_page()
    {
        $response = $this->get(route('profile'));
        $response->assertStatus(302)->assertRedirect('/login');
    }

    public function test_allows_authenticated_user_to_access_edit_profile_page()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('edit_profile'));
        $response->assertStatus(200);
    }

    public function test_does_not_allow_non_authenticated_user_to_access_edit_profile_page()
    {
        $response = $this->get(route('edit_profile'));
        $response->assertStatus(302)->assertRedirect('/login');
    }

    public function test_allows_authenticated_user_to_update_profile()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('update_profile',$user->id), [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'newpassword',
            'address' => $this->faker->address,
        ]);
        $response->assertStatus(302)->assertRedirect('/profile');
    }

    public function test_does_not_allow_non_authenticated_user_to_update_profile()
    {
        $response = $this->post('/update_profile/1', [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'password' => 'newpassword',
            'address' => 'Updated Address',
        ]);
        $response->assertStatus(302)->assertRedirect('/login');
    }
}
