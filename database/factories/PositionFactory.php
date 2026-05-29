<?php

namespace Database\Factories;

use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Position>
 */
class PositionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->unique()->randomElement([
                'HR Manager',
                'Recruiter',
                'Software Developer',
                'System Administrator',
                'Finance Officer',
                'Marketing Specialist',
                'Support Agent',
            ]),
            'base_salary' => fake()->numberBetween(2800, 6500),
        ];
    }
}
