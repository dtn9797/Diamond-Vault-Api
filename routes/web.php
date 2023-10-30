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

// admin registration
//$router->post('admin','App\Http\Controllers\AdminController@createAdmin');

// admin profile update
//$router->put('admin/{id}', 'App\Http\Controllers\AdminController@updateAdmin');

// Password change
//$router->post('admin/{id}/change-password', 'App\Http\Controllers\ChangePasswordController@changePassword');

//$router->get('admin','App\Http\Controllers\AdminController@index');

// Route to initiate the password reset process by creating a reset token
$router->post('password/reset', 'App\Http\Controllers\PasswordResetController@createToken');

// Route to handle password reset using a valid token
$router->post('password/reset/{token}', 'App\Http\Controllers\PasswordResetController@resetPassword')->middleware('auth:api');

//for logout
Route::post('/logout', 'LogoutController@logout')->middleware('auth:api');

//updating admin with token concept
Route::put('/admin/{id}', 'AdminController@updateAdmin')->middleware('auth:api');

//retrieving the records of admin using token concept
Route::get('/admins', 'AdminController@index')->middleware('auth:api');




