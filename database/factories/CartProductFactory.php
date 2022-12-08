<?php

namespace Database\Factories;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CartProduct>
 */
class CartProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name,
            'product_unit_count' => fake()->randomNumber(3),
            'unit_price' => fake()->randomNumber(3),
            'total_price' => fake()->randomNumber(4),
            'cart_id' => 1
        ];
    }
}
