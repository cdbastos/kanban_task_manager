<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence,
            'description' => fake()->paragraph,
            'urgent' => fake()->randomElement([true, false]),
            'progress' => fake()->numberBetween(0, 100),
            'status' => fake()->randomElement(['Haciendo', 'Por Hacer', 'Hecho']),
            'due_date' => fake()->optional()->dateTimeBetween('now', '+10 days'),
            'user_id' => 1,
        ];
    }
}
