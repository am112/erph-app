<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Select>
 */
class SelectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['strategy', 'field', 'language', 'discipline', 'standard'];
        return [
            "type"=> $types[array_rand($types)],
            'name' => $this->faker->sentence,
            'code' => $this->faker->countryCode,
        ];
    }
}
