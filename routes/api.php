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


Route::post('/register', 'App\Http\Controllers\AuthController@register');
Route::post('/login', 'App\Http\Controllers\AuthController@login');
//test need to remove later
Route::post('/removeAllAdmins','App\Http\Controllers\AuthController@removeAll');
Route::group(['middleware'=>['auth:sanctum']],function(){ 
    Route::post('/logout', 'App\Http\Controllers\AuthController@logout');

});