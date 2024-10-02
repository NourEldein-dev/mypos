<?php

use App\Http\Controllers\Dashboard\Client\OrderController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\OrdersController;
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

//get order products in edit blade
Route::get('clients/orders/{order}/products' , [OrderController::class , 'getOrderProducts']);


//get order products in index blade
Route::get('orders/{order}/products' , [OrdersController::class , 'products']);


//get data chart 
Route::get('/sales-data', [DashboardController::class, 'getSalesData']);