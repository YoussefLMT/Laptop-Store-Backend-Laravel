<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;

class CartController extends Controller
{
    
    function addToCart(Request $request){

        Cart::create([
            'user_id'=> auth()->user()->id,
            'product_id'=> $request->product_id
        ]);
        
        return response()->json([
            'status' => 200,
            'message' => "Added to cart successfully",
        ]);
    
    }

}
