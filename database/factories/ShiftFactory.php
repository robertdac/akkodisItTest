<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shift>
 */
class ShiftFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('-3 months', '+1 month');
        $end = (clone $start)->modify('+' . rand(1, 5) . ' days');

        return [
            'type' => $this->faker->randomElement(['work', 'vacation', 'off']),
            'start_date' => $start->format('Y-m-d H:i:s'),
            'end_date' => $end->format('Y-m-d H:i:s'),
        ];
    }
}
