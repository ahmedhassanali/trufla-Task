<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->title(),
            'amount_avilable'=>fake()->numberBetween(1,20),
            'cost'=>fake()->numberBetween(1,1000),
            'description'=>fake()->text(),
            'added_by'=>fake()->numberBetween(1,10),
        ];
    }
}
