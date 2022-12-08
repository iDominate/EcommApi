<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    //'id', "name_of_owner", "email_of_owner","user_id","number_of_products","number_of_items","total_price", "status", "order_date"
    public function definition()
    {
        return [
            'name_of_owner' => fake()->name(),
            'email_of_owner' => fake()->email(),
            'user_id' => 1,
            'number_of_products' => fake()->randomNumber(2),
            'number_of_items' => fake()->randomNumber(3),
            'total_price' => fake()->randomNumber(5),
            'status' => 0,
            'order_date' => now()
        ];
    }
}
