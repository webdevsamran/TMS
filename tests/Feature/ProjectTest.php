<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_allows_authenticated_user_to_access_project_page()
    {
        $user = User::factory()->create(['role'=>2]);
        $response = $this->actingAs($user)->get(route('project'));
        $response->assertStatus(200);
        $response->assertViewIs('dashboard.project');
    }

    public function test_allows_authenticated_user_to_access_add_project_page()
    {
        $user = User::factory()->create(['role'=>2]);
        $response = $this->actingAs($user)->get(route('add_project'));
        $response->assertStatus(200);
        $response->assertViewIs('dashboard.project.add_project');
    }

    public function test_allows_authenticated_user_to_add_new_project()
    {
        $user = User::factory()->create(['role'=>2]);
        $project = Project::factory()->create();
        $data = [
            'name' => $project->name,
            'manager' => $project->manager,
            'developer' => $project->developer,
            'starting_date' => $project->starting_date,
            'ending_date' => $project->ending_date,
            'documents' => NULL,
            'description' => $project->description
        ];
        $response = $this->actingAs($user)->post(route('add_new_project'), $data);
        $response->assertRedirect(route('project'));
        $this->assertDatabaseHas('projects', ['name' => $data['name']]);
    }

    public function test_validates_add_new_project_form()
    {
        $user = User::factory()->create(['role'=>2]);
        $response = $this->actingAs($user)->post(route('add_new_project'), []);
        $response->assertSessionHasErrors(['name', 'manager', 'developer', 'starting_date', 'ending_date', 'description']);
    }

    public function test_allows_authenticated_user_to_access_edit_project_page()
    {
        $user = User::factory()->create(['role'=>2]);
        $project = Project::factory()->create();
        $response = $this->actingAs($user)->get(route('edit_project', $project->id));
        $response->assertStatus(200);
        $response->assertViewIs('dashboard.project.edit_project');
    }

    public function test_allows_authenticated_user_to_edit_project()
    {
        $user = User::factory()->create(['role'=>2]);
        $project = Project::factory()->create();
        $data = [
            'name' => $this->faker->sentence,
            'manager' => $project->manager,
            'developer' => $project->developer,
            'documents' => NULL,
            'starting_date' => $project->starting_date,
            'ending_date' => $project->ending_date,
            'status' => 1,
            'description' => $this->faker->paragraph,
        ];

        $response = $this->actingAs($user)->post(route('edit_new_project', $project->id), $data);
        $response->assertRedirect(route('project'));
        $this->assertDatabaseHas('projects', ['name' => $data['name']]);
    }

    public function test_validates_edit_project_form()
    {
        $user = User::factory()->create(['role'=>2]);
        $project = Project::factory()->create();
        $response = $this->actingAs($user)->post(route('edit_new_project', $project->id), []);
        $response->assertSessionHasErrors(['name', 'manager', 'developer', 'starting_date', 'ending_date', 'status', 'description']);
    }

    public function test_allows_authenticated_user_to_delete_project()
    {
        $user = User::factory()->create(['role'=>2]);
        $project = Project::factory()->create();
        $response = $this->actingAs($user)->get(route('delete_project', $project->id));
        $response->assertRedirect(route('project'));
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }
}
