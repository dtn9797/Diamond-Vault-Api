<?php

namespace App\Http\Controllers;

use App\Models\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ProductController extends Controller
{
    public function createProduct(Request $request){
        $product = Product::create($request->all());
        return response()->json($product);
    }

    public function updateProduct(Request $request, $id){
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
    
        $product->update($request->all());
    
        return response()->json(['message' => 'Product updated successfully']);
    
    }  

    public function deleteProduct($id){
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
    
        $product->delete();
    
        return response()->json(['message' => 'Product removed successfully']);
    }

    public function index(){
        $products  = Product::all();
           $response["products"] = $products;
           $response["success"] = 1;
        return response()->json($response);
    }
    
}
