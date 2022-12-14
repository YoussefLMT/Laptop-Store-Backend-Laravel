<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StatisticsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::get('products', [ProductController::class, 'getProducts']);
Route::post('add-product', [ProductController::class, 'addProduct']);
Route::get('get-product/{id}', [ProductController::class, 'getProduct']);
Route::put('update-product/{id}', [ProductController::class, 'updateProduct']);
Route::delete('delete-product/{id}', [ProductController::class, 'deleteProduct']);
Route::get('specific-products', [ProductController::class, 'getSpecificProducts']);


Route::get('users', [UserController::class, 'getUsers']);
Route::post('add-user', [UserController::class, 'addUser']);
Route::get('get-user/{id}', [UserController::class, 'getUser']);
Route::put('update-user/{id}', [UserController::class, 'updateUser']);
Route::delete('delete-user/{id}', [UserController::class, 'deleteUser']);



Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('logout', [AuthController::class, 'logOut']);
    
    Route::post('add-to-cart/{product_id}', [CartController::class, 'addToCart']);
    Route::get('cart-count', [CartController::class, 'getCartCount']);
    Route::get('get-cart-prducts', [CartController::class, 'getCartProducts']);
    Route::delete('remove-product/{id}', [CartController::class, 'removeProduct']);

    Route::post('place-order', [OrderController::class, 'placeOrder']);
    Route::get('total-price', [OrderController::class, 'getOrderTotalPrice']);
    Route::get('get-user-orders', [OrderController::class, 'getUserOrders']);

    Route::get('get-orders', [OrderController::class, 'getAllOrders']);
    Route::get('get-order-products/{id}', [OrderController::class, 'getOrderProducts']);
    Route::put('update-order-status/{id}', [OrderController::class, 'updateOrderStatus']);

    Route::get('statistics', [StatisticsController::class, 'getTotalCount']);
    Route::get('orders-statistics', [StatisticsController::class, 'getOrdersStatistics']);


});




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
