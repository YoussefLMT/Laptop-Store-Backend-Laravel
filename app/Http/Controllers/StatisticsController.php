<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    
    public function getTotalCount(){

        $productsCount = Product::all()->count();
        $usersCount = User::all()->count();
        $ordersCount = Order::all()->count();

        $income = DB::table('orders')
        ->join('order_products', 'order_products.order_id', '=', 'orders.id')
        ->join('products', 'order_products.product_id', '=', 'products.id')
        ->sum('products.price');

        return response()->json([
            'status' => 200,
            'productsCount' => $productsCount,
            'usersCount' => $usersCount,
            'ordersCount' => $ordersCount,
            'income' => $income
        ]);
    }



    public function getOrdersStatistics(){

        $monthlyArray = array();
        $emptyMonth = array('count' => 0, 'month' => 0);
        for($i = 1; $i <= 12; $i++){
            $emptyMonth['month'] = $i;
            $monthlyArray[$i-1] = $emptyMonth;
        }
        
        $count = Order::select(DB::raw('YEAR(created_at) year'), DB::raw('MONTH(created_at) month'), DB::raw('count(id) as `count`'))
        ->groupBy('year','month')
        ->orderByRaw('month')
        ->get()
        ->toArray();

        foreach($count as $key => $array){
            $monthlyArray[$array['month']-1] = $array;
        }

        return response()->json([
            'status' => 200,
            'ordersCount' => $monthlyArray,
        ]);
    }

}
