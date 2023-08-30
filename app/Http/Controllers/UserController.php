<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function mostExpensiveOrder() {

        $expensiveOrders = User::select('users.name', DB::raw('MAX(orders.total_amount) as mostExpensivePurchase, "usd" as currency'),)
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

        $users = User::select('users.name', DB::raw('SUM(orders.total_amount) as totalOrderValue, "usd" as currency'))
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->groupBy('users.id', 'users.name')
            ->havingRaw('totalOrderValue = (SELECT SUM(o.total_amount) FROM users u JOIN orders o ON u.id = o.user_id GROUP BY u.id ORDER BY SUM(o.total_amount) DESC LIMIT 1)')
            ->get();

        return response()->json(['users' => $users]);
    }
}
