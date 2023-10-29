<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

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


// Route to initiate the password reset process by creating a reset token
$router->post('password/reset', 'App\Http\Controllers\PasswordResetController@createToken');

// Route to handle password reset using a valid token
$router->post('password/reset/{token}', 'App\Http\Controllers\PasswordResetController@resetPassword')->middleware('auth:api');

// //for logout
// Route::post('/logout', 'LogoutController@logout')->middleware('auth:api');

// //updating admin with token concept
// Route::put('/admin/{id}', 'AuthController@updateAdmin')->middleware('auth:api');

// //retrieving the records of admin using token concept
// //Route::get('/admins', 'AuthController@index')->middleware('auth:api');

// //Route::post('/register', 'App\Http\Controllers\AdminController@register');

// Route::get('/admin', 'App\Http\Controllers\AuthController@index');
// //Route::post('/register', 'App\Http\Controllers\AuthController@register');


// Admin Registration Routes
$router->prefix('admin')->group(function () {
    //Route::get('/register', 'AdminAuth\RegisterController@showRegistrationForm')->name('admin.register');
    Route::post('/register', 'App\Http\Controllers\AdminAuth\RegisterController@register');
});

Route::get('register', [RegisterController::class, 'register']);
Route::post('register', [RegisterController::class, 'store'])->name('register');

Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('login', [LoginController::class, 'authenticate']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

//Route::get('home', [HomeController::class, 'home'])->name('home');

Route::get('forget-password', [ForgotPasswordController::class, 'getEmail']);
Route::post('forget-password', [ForgotPasswordController::class, 'postEmail']);

Route::get('reset-password/{token}', [ResetPasswordController::class, 'getPassword']);
Route::post('reset-password', [ResetPasswordController::class, 'updatePassword']);
