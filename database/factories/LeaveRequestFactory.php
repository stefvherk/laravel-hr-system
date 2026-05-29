<?php

namespace Database\Factories;

use App\Models\LeaveRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LeaveRequest>
 */
class LeaveRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employee_id' => null,
            'start_date' => fake()->dateTimeBetween('-2 months', '+1 month')->format('Y-m-d'),
            'end_date' => fake()->dateTimeBetween('now', '+2 months')->format('Y-m-d'),
            'reason' => fake()->randomElement([
                'Vacation',
                'Medical appointment',
                'Family obligation',
                'Personal leave',
                'Recovery day',
            ]),
            'status' => fake()->randomElement([
                'pending',
                'approved',
                'rejected',
                'cancelled',
                'expired',
            ]),
        ];
    }
}
