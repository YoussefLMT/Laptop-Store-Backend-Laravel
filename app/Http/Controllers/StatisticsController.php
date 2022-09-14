<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;

class StatisticsController extends Controller
{
    
    public function getTotalCount(){

        $productsCount = Product::all()->count();
        $usersCount = User::all()->count();
        $ordersCount = Order::all()->count();

        return response()->json([
            'status' => 200,
            'productsCount' => $productsCount,
            'usersCount' => $usersCount,
            'ordersCount' => $ordersCount,
        ]);
    }
}
