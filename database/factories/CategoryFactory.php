<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // 'name', 'number_of_products', 'total_items_in_stock', 'total_profit', 'total_items_sold'
        return [
            'name' => fake()->name,
            'number_of_products' => fake()->randomNumber(3),
            'total_items_in_stock' => fake()->randomNumber(3),
            'total_profit' => fake()->randomNumber(6),
            'total_items_sold' => fake()->randomNumber(3)
        ];
    }
}
