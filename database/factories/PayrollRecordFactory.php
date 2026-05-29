<?php

namespace Database\Factories;

use App\Models\PayrollRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PayrollRecord>
 */
class PayrollRecordFactory extends Factory
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
            'pay_period' => now()->startOfMonth()->format('Y-m-d'),
            'base_salary' => 0,
            'bonus' => fake()->optional(0.25, 0)->numberBetween(100, 750),
            'deductions' => fake()->optional(0.30, 0)->numberBetween(50, 400),
        ];

    }
}
