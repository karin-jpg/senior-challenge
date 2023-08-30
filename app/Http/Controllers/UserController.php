<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function mostExpensiveOrder() {

        $expensiveOrders = User::select('users.name', DB::raw('MAX(orders.total_amount) as mostExpensivePurchase'))
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->groupBy('users.id')
            ->orderBy('mostExpensivePurchase', 'desc')
            ->get();

        return response()->json(['users' => $expensiveOrders]);
    }

    public function usersWhoHavePurchasedAllProducts() {
        $users = User::select('users.name')
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->groupBy('users.id')
            ->havingRaw('COUNT(DISTINCT products.id) = (select COUNT(id) FROM products)')
            ->get();

        return response()->json(['users' => $users]);
    }

    public function usersWithHighestTotalOrderValue() {

        $users = User::select('users.name', DB::raw('SUM(orders.total_amount) as totalOrderValue'))
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->groupBy('users.id', 'users.name')
            ->havingRaw('totalOrderValue = (SELECT MAX(totalOrderValue) FROM (SELECT SUM(total_amount) as totalOrderValue FROM orders GROUP BY user_id) as sales_table)')
            ->get();

        return response()->json(['users' => $users]);
    }
}
