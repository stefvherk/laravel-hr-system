<?php

namespace Database\Factories;

use App\Models\AttendanceRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AttendanceRecord>
 */
class AttendanceRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $checkIn = fake()->dateTimeBetween('-2 months', 'now');
        $checkOut = (clone $checkIn)->modify('+' . fake()->numberBetween(6, 10) . ' hours');

        return [
            'employee_id' => null,
            'check_in_at' => $checkIn,
            'check_out_at' => $checkOut,
        ];
    }
}
