<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{

    //'name', 'in_stock', 'sold', 'total_profit', 'rate'
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name,
            'in_stock' => fake()->randomNumber(3),
            'sold' => fake()->randomNumber(3),
            'total_profit' => fake()->randomNumber(7),
            'rate' => fake()->randomNumber(1),
            'category_id' => Category::factory()->create()->id,
            'unit_price' => fake()->randomNumber(3)
        ];
    }
}
