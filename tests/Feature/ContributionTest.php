<?php

namespace Tests\Feature;

use App\Models\Contribution;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;

class ContributionTest extends TestCase
{
    use RefreshDatabase;

    public function test_allows_authenticated_user_to_access_contribution_page()
    {
        $user = User::factory()->create(['role'=>0]);
        $response = $this->actingAs($user)->get(route('contribution'));
        $response->assertStatus(200);
    }

    public function test_allows_authenticated_user_to_add_contribution()
    {
        $user = User::factory()->create(['role'=>0]);
        $contribution = Contribution::factory()->create();
        $data = [
            'title' => $contribution->title,
            'description' => $contribution->description,
            'task_id' => $contribution->task_id,
            'developer_id' => $contribution->developer_id
        ];
        $response = $this->actingAs($user)->post(route('add_contribution',$contribution->task_id), $data);
        $response->assertStatus(200);
    }
}
