<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductTestingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Product::insert([
            [
                'name' => 'Television',
                'price' => 1000
            ],
            [
                'name' => 'Notebook',
                'email' => 2099.99
            ],
            [
                'name' => 'Cellphone',
                'email' => 875.20
            ],
            [
                'name' => 'PS5 Controller',
                'email' => 300.79
            ],
            [
                'name' => 'Mouse',
                'email' => 15.78
            ]
        ]);
    }
}
