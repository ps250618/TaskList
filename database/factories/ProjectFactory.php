<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        $code = 'PRJ-'.strtoupper($this->faker->bothify('??###'));

        return [
            'name' => fake()->words(3, true),
            'description' => $this->faker->text(200),
            'code' => $code,
            'status' => $this->faker->randomElement(['active', 'on_hold', 'archived']),
            'team_id' => null,
        ];
    }
}
