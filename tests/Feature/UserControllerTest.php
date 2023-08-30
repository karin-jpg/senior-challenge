<?php

namespace Tests\Feature;

use Database\Seeders\OrderTestingSeeder;
use Database\Seeders\ProductTestingSeeder;
use Database\Seeders\UserTestingSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed([UserTestingSeeder::class, ProductTestingSeeder::class, OrderTestingSeeder::class]);
    }
    /**
     * A basic feature test example.
     */

    public function test_is_database_set_correctly(): void
    {
        $this->assertDatabaseCount('users', 3);
        $this->assertDatabaseCount('products', 3);
        $this->assertDatabaseCount('orders', 7);
    }

    public function test_assert_most_expensive_order_from_all_users_asc_order(): void
    {
        $response = $this->get('/api/users/order/most-expensive');

        $response->assertJson(fn (AssertableJson $json) =>
            $json->has('users', 3)
                ->where('users.0.mostExpensivePurchase', 15000)
                ->where('users.0.name', 'Lucas')
                ->where('users.1.mostExpensivePurchase', 10000)
                ->where('users.1.name', 'Robert')
                ->where('users.2.mostExpensivePurchase', 7502.5)
                ->where('users.2.name', 'Paul')
        );
        $response->assertStatus(200);
    }
}
