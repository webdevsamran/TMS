<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContributionFactory extends Factory
{

    public function definition()
    {
        $task = Task::factory()->create();

        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'task_id' => $task->id,
            'developer_id' => $task->developer_id
        ];
    }
}
