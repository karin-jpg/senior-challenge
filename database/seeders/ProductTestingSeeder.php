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
                'price' => 1500
            ],
            [
                'name' => 'Cellphone',
                'price' => 500
            ]
        ]);
    }
}
