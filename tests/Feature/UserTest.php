<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_allows_authenticated_user_to_access_user_page()
    {
        $user = User::factory()->create(['role' => 2]);
        $response = $this->actingAs($user)->get(route('user'));
        $response->assertStatus(200);
    }

    public function test_allows_authenticated_user_to_access_add_user_page()
    {
        $user = User::factory()->create(['role' => 2]);
        $response = $this->actingAs($user)->get(route('add_user'));
        $response->assertStatus(200);
    }

    public function test_allows_authenticated_user_to_add_new_user()
    {
        $user = User::factory()->create(['role' => 2]);
        $this->actingAs($user);
        Bus::fake();
        $data = [
            'name' => $this->faker->name,
            'role' => 0,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password',
            'address' => $this->faker->address,
        ];
        $response = $this->post(route('add_new_user'), $data);
        $response->assertStatus(302)->assertRedirect('/user');
        Bus::assertDispatched(\App\Jobs\ProcessMail::class);
    }

    public function test_validates_add_new_user_form()
    {
        $user = User::factory()->create(['role'=>2]);
        $response = $this->actingAs($user)->post(route('add_new_user'), []);
        $response->assertSessionHasErrors(['name', 'email', 'password', 'address']);
    }

    public function test_allows_authenticated_user_to_edit_user_page()
    {
        $user = User::factory()->create(['role'=>2]);
        $newUser = User::factory()->create();
        $response = $this->actingAs($user)->get(route('edit_user',$newUser->id));
        $response->assertStatus(200);
        $response->assertViewIs('dashboard.user.edit_user');
    }

    public function test_allows_authenticated_user_to_update_user()
    {
        $user = User::factory()->create(['role'=>2]);
        $newUser = User::factory()->create(['email'=>$this->faker->unique()->safeEmail]);
        $data = [
            'name' => $newUser->name,
            'role' => 1,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password',
            'address' => $newUser->address,
        ];
        $response = $this->actingAs($user)->post(route('update_user',$newUser->id), $data);
        $response->assertRedirect('/user')->assertSessionHas('message', 'User Updated Successfully');
    }

    public function test_validates_update_user_form()
    {
        $user = User::factory()->create(['role'=>2]);
        $newUser = User::factory()->create();
        $response = $this->actingAs($user)->post(route('update_user',$newUser->id), []);
        $response->assertSessionHasErrors(['name', 'role', 'address']);
    }

    public function test_allows_authenticated_user_to_delete_user()
    {
        $user = User::factory()->create(['role'=>2]);
        $newUser = User::factory()->create();
        $response = $this->actingAs($user)->get(route('delete_user',$newUser->id));
        $response->assertRedirect('/user')->assertSessionHas('message', 'User Deleted Successfully');
    }
}
