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
                'price' => 5000
            ],
            [
                'name' => 'Notebook',
                'email' => 1500.50
            ],
            [
                'name' => 'Cellphone',
                'email' => 500.99
            ]
        ]);
    }
}
