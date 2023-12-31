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

    public function test_most_expensive_order_from_all_users_asc_order(): void
    {
        $response = $this->get('/api/users/order/most-expensive');

        $response->assertJson(fn (AssertableJson $json) =>
            $json->has('users', 3)
                ->where('users.0.mostExpensivePurchase', 15000)
                ->where('users.0.name', 'Lucas')
                ->where('users.1.mostExpensivePurchase', 15000)
                ->where('users.1.name', 'Robert')
                ->where('users.2.mostExpensivePurchase', 7500)
                ->where('users.2.name', 'Paul')
        );
        $response->assertStatus(200);
    }

    public function test_retrieve_user_who_have_purchased_all_available_products(): void
    {
        $response = $this->get('/api/users/purchased-all-products');

        $response->assertJson(fn (AssertableJson $json) =>
            $json->has('users', 1)
                ->where('users.0.name', 'Robert')
        );
        $response->assertStatus(200);
    }


    public function test_retrieve_users_with_highest_total_orders(): void
    {
        $response = $this->get('/api/users/highest-total-orders');
        $response->assertJson(fn (AssertableJson $json) =>
        $json->has('users', 2)
            ->where('users.0.name', 'Robert')
            ->where('users.0.totalOrderValue', 21000)
            ->where('users.1.name', 'Lucas')
            ->where('users.1.totalOrderValue', 21000)
        );
        $response->assertStatus(200);
    }
}
