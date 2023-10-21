<?php

namespace App\Http\Controllers;

use App\Models\Product;

use Illuminate\Http\Request;

//use DB;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function createProduct(Request $request)
    {
       $product = Product::create($request->all());
       //'name' => 'string'
        return response()->json(['product' => $product]);
    }

    public function updateProduct(Request $request, $id)
    {
        //$product = DB::table('product')->where('id',$request->input('pid'))->get();
        $product = Product::find($id);
        $product->name = $request->input('name');
        $product->metal = $request->input('metal');
        $product->description = $request->input('description');
        $product->silverPrice = $request->input('goldPrice');
        $product->creationDate = $request->input('retailPrice');
        $product->size = $request->input('size');
        $product->category = $request->input('category');
        $product->email = $request->input('email');
        $product->ImageUrl = $request->input('ImageUrl');
        /*$product->remember_token = $request->input('remember_token');
        $product->created_at = $request->input('created_at');
        $product->updated_at = $request->input('updated_at');*/

    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);
        $product->delete();
        return response()->json('Removed successfully.');
    }

    public function index()
    {
        $product = Product::all();
        $response["product"] = $product;
        $response["success"] = 1;
        return response()->json($response);

    }
}

?>


