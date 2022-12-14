<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;

class OrderController extends Controller
{

    function getOrderTotalPrice(){

        $user_id = auth()->user()->id;

        $total_price = DB::table('cart')
        ->join('products', 'cart.product_id', '=', 'products.id')
        ->where('cart.user_id', $user_id)
        ->sum('products.price');

        return response()->json([
            'status' => 200,
            'total_price' => $total_price,
        ]);
    }


    
    function placeOrder(Request $request){
        
        $user_id = auth()->user()->id;

        $cart_data = Cart::where('user_id', $user_id)->get();

        $total_price = DB::table('cart')
        ->join('products', 'cart.product_id', '=', 'products.id')
        ->where('cart.user_id', $user_id)
        ->sum('products.price');

        $order = Order::create([
            'user_id' => $user_id,
            'address' => $request->address,
            'city' => $request->city,
            'total_amount' => $total_price
        ]);

        foreach($cart_data as $cart){

            $order_products = new OrderProduct;
            $order_products->order_id = $order->id;
            $order_products->product_id = $cart->product_id;
            $order_products->save();
            
            Cart::where('user_id', $user_id)->delete();
        }
        
        return response()->json([
            'status' => 200,
            'message' => "Your order has been placed successfully",
        ]);
    }



    function getUserOrders(){

        $user_id = auth()->user()->id;
        $orders = DB::table('orders')
        ->join('order_products', 'order_products.order_id', '=', 'orders.id')
        ->join('products', 'order_products.product_id', '=', 'products.id')
        ->where('orders.user_id', $user_id)
        ->get();

        if($orders){

            return response()->json([
                'status' => 200,
                'orders' =>  $orders
            ]);
        }else{

            return response()->json([
                'status' => 401,
                'message' =>  "You don't have any order yet"
            ]);
        }

    }



    function getAllOrders(){

        $orders = Order::all();

        return response()->json([
            'status' => 200,
            'orders' =>  $orders
        ]);

    }


    
    function getOrderProducts($id){

        $order_products = DB::table('orders')
        ->join('order_products', 'order_products.order_id', '=', 'orders.id')
        ->join('products', 'order_products.product_id', '=', 'products.id')
        ->where('orders.id', $id)
        ->get();

        return response()->json([
            'status' => 200,
            'order_products' =>  $order_products
        ]);
    }



    function updateOrderStatus(Request $request, $id){

        $order = Order::find($id);
        if($order){

            $order->status = $request->status;
            $order->save();

            return response()->json([
                'status' => 200,
                'message' => "Updated successully",
            ]);

        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Order not found!',
            ]);
        }
    }
}
