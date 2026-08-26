<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->text(200),
            'status' => $this->faker->randomElement(['todo', 'doing', 'done', 'blocked']),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'due_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'estimate_minutes' => $this->faker->numberBetween(30, 480),
            'project_id' => null,
            'assignee_id' => null,
        ];
    }
}
