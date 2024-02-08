<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_allows_authenticated_user_to_access_task_page()
    {
        $user = User::factory()->create(['role'=>1]);
        $response = $this->actingAs($user)->get('/task');
        $response->assertStatus(200);
    }

    public function test_allows_authenticated_user_to_access_add_task_page()
    {
        $user = User::factory()->create(['role'=>1]);
        $response = $this->actingAs($user)->get('/add_task');
        $response->assertStatus(200);
    }

    public function test_allows_authenticated_user_to_add_task()
    {
        $user = User::factory()->create(['role'=>1]);
        $task = Task::factory()->create();
        $data = [
            'name' => $task->name,
            'starting_date' => $task->starting_date,
            'ending_date' => $task->ending_date,
            'description' => $task->description,
            'project_id' => $task->project_id,
            'manager_id' => $task->manager_id,
            'developer_id' => $task->developer_id
        ];
        $response = $this->actingAs($user)->post(route('add_new_task'), $data);
        $response->assertRedirect('/task')->assertSessionHas('message', 'Task Added Successfully');
    }

    public function test_validates_add_new_task_form()
    {
        $user = User::factory()->create(['role'=>1]);
        $response = $this->actingAs($user)->post(route('add_new_task'), []);
        $response->assertSessionHasErrors(['name', 'project_id', 'manager_id', 'developer_id', 'starting_date', 'ending_date', 'description']);
    }

    public function test_allows_authenticated_user_to_edit_task_page()
    {
        $user = User::factory()->create(['role'=>1]);
        $task = Task::factory()->create();
        $response = $this->actingAs($user)->get(route('edit_task',$task->id));
        $response->assertStatus(200);
        $response->assertViewIs('dashboard.task.edit_task');
    }

    public function test_allows_authenticated_user_to_update_task()
    {
        $user = User::factory()->create(['role'=>1]);
        $task = Task::factory()->create();
        $data = [
            'name' => $task->name,
            'starting_date' => $task->starting_date,
            'ending_date' => $task->ending_date,
            'description' => $task->description,
            'status' => 1,
            'project_id' => $task->project_id,
            'manager_id' => $task->manager_id,
            'developer_id' => $task->developer_id
        ];
        $response = $this->actingAs($user)->post("/update_task/{$task->id}", $data);
        $response->assertRedirect('/task')->assertSessionHas('message', 'Task Updated Successfully');
    }

    public function test_validates_update_task_form()
    {
        $user = User::factory()->create(['role'=>1]);
        $task = Task::factory()->create();
        $response = $this->actingAs($user)->post(route('update_task',$task->id), []);
        $response->assertSessionHasErrors(['name', 'project_id', 'manager_id', 'developer_id', 'starting_date', 'ending_date', 'description', 'status']);
    }

    public function test_allows_authenticated_user_to_delete_task()
    {
        $user = User::factory()->create(['role'=>1]);
        $task = Task::factory()->create();
        $response = $this->actingAs($user)->get(route('delete_task',$task->id));
        $response->assertRedirect('/task')->assertSessionHas('message', 'Task Deleted Successfully');
    }
}
