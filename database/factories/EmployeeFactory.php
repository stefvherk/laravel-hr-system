<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Department;
use App\Models\Position;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'department_id' => null, //Toegewezen in seeder
            'position_id' => null, //Toegewezen in seeder
            'hire_date' => fake()->dateTimeBetween('-5 years', 'now') -> format('Y-m-d'),
            'employment_status' => fake()->randomElement([
                'active',
                'active',
                'active',
                'on_leave',
                'inactive',
            ]),
        ];
    }
}
