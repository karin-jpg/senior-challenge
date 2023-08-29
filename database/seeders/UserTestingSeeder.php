<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTestingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Robert',
                'email' => fake()->unique()->safeEmail()
            ],
            [
                'name' => 'Paul',
                'email' => fake()->unique()->safeEmail()
            ],
            [
                'name' => 'Lucas',
                'email' => fake()->unique()->safeEmail()
            ]
        ]);
    }
}
