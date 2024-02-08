<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Models\Feedback;

class FeedbackTest extends TestCase
{
    use RefreshDatabase;

    public function test_allows_authenticated_user_to_access_feedback_page()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('feedback'));
        $response->assertStatus(200);
    }

    public function test_does_not_allow_non_authenticated_user_to_access_feedback_page()
    {
        $response = $this->get(route('feedback'));
        $response->assertStatus(302)->assertRedirect('/login');
    }

    public function test_allows_authenticated_user_to_access_give_feedback_page()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['status'=>2]);
        $response = $this->actingAs($user)->get(route('give_feedback', $project->id));
        $response->assertStatus(200);
    }

    public function test_does_not_allow_non_authenticated_user_to_access_give_feedback_page()
    {
        $project = Project::factory()->create(['status'=>2]);
        $response = $this->get(route('give_feedback', $project->id));
        $response->assertStatus(302)->assertRedirect('/login');
    }

    public function test_allows_authenticated_user_to_add_feedback()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['status'=>2]);
        $response = $this->actingAs($user)->post(route('add_new_feedback', $project->id), [
            'title' => 'Test Feedback',
            'stars' => 5,
            'feedback' => 'This is a test feedback with more than 50 characters.',
        ]);
        $response->assertStatus(302)->assertRedirect('/feedback');
    }

    public function test_does_not_allow_non_authenticated_user_to_add_feedback()
    {
        $project = Project::factory()->create(['status'=>2]);
        $response = $this->post(route('add_new_feedback', $project->id), [
            'title' => 'Test Feedback',
            'stars' => 5,
            'feedback' => 'This is a test feedback with more than 50 characters.',
        ]);
        $response->assertStatus(302)->assertRedirect('/login');
    }
}
