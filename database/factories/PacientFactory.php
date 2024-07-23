<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pacient>
 */
class PacientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nume' => fake()->lastName(),
            'prenume' => fake()->firstName(),
            'telefon' => '07' . fake()->numberBetween(10000000, 99999999),
            'data_nastere' => \Carbon\Carbon::today()->subDays(rand(1000, 30000)),
            'localitate_id' => \App\Models\Localitate::inRandomOrder()->first()->id,
            'created_at' => \Carbon\Carbon::today()->subDays(rand(1, 100)),
        ];
    }
}
