<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition()
    {
        $manager = User::factory()->create(['role' => 1]);
        $developer = User::factory()->create(['role' => 0]);
 
        return [
            'name' => $this->faker->sentence,
            'manager' => $manager->id,
            'developer' => $developer->id,
            'file' => NULL,
            'starting_date' => now(),
            'ending_date' => now()->addDays(5),
            'description' => $this->faker->paragraph,
        ];
    }
}
