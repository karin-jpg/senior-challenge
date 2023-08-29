<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $user_id = User::inRandomOrder()->first(['id'])->id;
        $product_id = Product::inRandomOrder()->first(['id'])->id;
        $quantity = fake()->randomDigitNot(0);
        $product_price = Product::where('id', $product_id)->first(['price'])->price;
        $total_amount = $product_price * $quantity;

        return [
            'user_id' => $user_id,
            'product_id' => $product_id,
            'quantity' => $quantity,
            'total_amount' => $total_amount
        ];
    }
}
