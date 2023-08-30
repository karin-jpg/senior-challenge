<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderTestingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::insert($this->get_insert_array_of_user1_with_all_products());
        Order::insert($this->get_insert_array_for_other_users());
    }

    private function get_insert_array_for_other_users() {
        return [
            [
                'user_id' => 2,
                'product_id' => 1,
                'quantity' => 1,
                'total_amount' => 5000
            ],
            [
                'user_id' => 2,
                'product_id' => 2,
                'quantity' => 5,
                'total_amount' => 7502.5
            ],
            [
                'user_id' => 3,
                'product_id' => 1,
                'quantity' => 3,
                'total_amount' => 15000
            ],
            [
                'user_id' => 3,
                'product_id' => 3,
                'quantity' => 2,
                'total_amount' => 1001.98
            ]
        ];
    }

    private function get_insert_array_of_user1_with_all_products() {
        return [
            [
                'user_id' => 1,
                'product_id' => 1,
                'quantity' => 3,
                'total_amount' => 15000
            ],
            [
                'user_id' => 1,
                'product_id' => 2,
                'quantity' => 3,
                'total_amount' => 4501.5
            ],
            [
                'user_id' => 1,
                'product_id' => 3,
                'quantity' => 3,
                'total_amount' => 1502.97
            ]
        ];
    }
}
