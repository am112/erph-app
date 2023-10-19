<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kokurikulum>
 */
class KokurikulumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(),
            'is_subitem' => mt_rand(1,10) > 7 ? true : false,
            'position' => mt_rand(1,10), 
        ];
    }
}
