<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Order_Product;

class OrderController extends Controller
{
    
    function placeOrder(Request $request){
        
        $user_id = auth()->user()->id;

        $cartData = Cart::where('user_id', $user_id)->get();

        $order = Order::create([
            'user_id' => $user_id,
            'address' => $req->address,
            'city' => $request->city
        ]);

        foreach($cartData as $cart){

            $order_products = new Order_Product;
            $order_products->order_id = $order->$order_id;
            $order_products->product_id = $cart->product_id;
            $order_products->save();
            
            Cart::where('user_id', $user_id)->delete();
        }
        
        return response()->json([
            'status' => 200,
            'message' => "Your order has been placed successfully",
        ]);
    }
}
