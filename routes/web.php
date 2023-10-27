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

// User registration
$router->post('user','App\Http\Controllers\UserController@createUser');

// User profile update
$router->put('user/{id}', 'App\Http\Controllers\UserController@updateUser');

// Password change
$router->post('user/{id}/change-password', 'App\Http\Controllers\ChangePasswordController@changePassword');

// Route to initiate the password reset process by creating a reset token
$router->post('password/reset', 'App\Http\Controllers\PasswordResetController@createToken');

// Route to handle password reset using a valid token
$router->post('password/reset/{token}', 'App\Http\Controllers\PasswordResetController@resetPassword');

$router->get('user','App\Http\Controllers\UserController@index');
