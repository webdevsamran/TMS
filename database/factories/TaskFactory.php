<?php

// database/factories/ProjectFactory.php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{

    public function definition()
    {
        $project = Project::factory()->create();
        $manager = $project->manager;
        $developer = $project->developer;

        return [
            'name' => $this->faker->sentence,
            'project_id' => $project->id,
            'manager_id' => $manager,
            'developer_id' => $developer,
            'starting_date' => now(),
            'ending_date' => now()->addDays(5),
            'description' => $this->faker->paragraph,
        ];
    }
}
