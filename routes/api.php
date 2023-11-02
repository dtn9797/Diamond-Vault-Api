<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Product entry
Route::post('product',[ProductController::class, 'createProduct']);

//Product update
Route::put('product/{id}',[ProductController::class,'updateProduct']);

//Product delete
Route::post('product/{id}',[ProductController::class,'deleteProduct']);

Route::get('product/{id}',[ProductController::class,'getProduct']);

Route::group(['middleware'=>['auth:sanctum']],function(){
    Route::post('','');
});
