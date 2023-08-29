<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function mostExpensiveOrder() {

        $expensiveOrders = User::select('users.name', DB::raw('max(orders.total_amount) as mostExpensivePurchase'))
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->groupBy('users.id')
            ->orderBy('mostExpensivePurchase', 'desc')
            ->get();

        return response()->json(['users' => $expensiveOrders]);
    }
}
