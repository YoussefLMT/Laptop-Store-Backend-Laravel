<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    
    public function addProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=> 'required',
            'price'=> 'required',
            'quantity' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        if($validator->fails()){

            return response()->json([
                'validation_err' => $validator->messages(),
            ]);

        }else{

            $product = new Product;
            $product->name = $request->name;
            $product->price = $request->price;
            $product->quantity = $request->quantity;
            $product->description = $request->description;

            if($request->hasFile('image'))
            {
                $image = $request->file('images');
                $extension = $image->getClientOriginalExtension();
                $image_name = time(). '.' .$extension;
                $image->move('uploads/images', $image_name);
                $product->image = 'uploads/images/' . $image_name;
            }

            $product->save();
    
            return response()->json([
                'status' => 200,
                'message' => "Customer added successfully",
            ]);
        }
    }
}