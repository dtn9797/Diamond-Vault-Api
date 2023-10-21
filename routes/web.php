<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
$router->post('product','App\Http\Controllers\ProductController@createProduct');   //for creating product
$router->get('product/{id}','App\Http\Controllers\ProductController@updateProduct'); //for updating product
$router->post('product/{id}','App\Http\Controllers\ProductController@deleteProduct');  // for deleting product
$router->get('product','App\Http\Controllers\ProductController@index'); // for retrieving product