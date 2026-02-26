<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SleepEntry>
 */
class SleepEntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'in_bed_by' => $this->faker->dateTime(),
            'awake_at' => $this->faker->dateTime(),
            'temperature' => $this->faker->numberBetween(55, 95),
            'rating' => $this->faker->numberBetween(1, 5),
            'notes' => $this->faker->paragraph(),
        ];
    }
}
