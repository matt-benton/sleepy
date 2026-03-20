<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KeyPoint>
 */
class KeyPointFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'is_positive' => $this->faker->numberBetween(0, 1),
            'text' => $this->faker->sentence,
        ];
    }

    public function positive(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'is_positive' => 1,
            ];
        });
    }
}
