<?php

use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\CartProduct\CartProductController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Order\OrderControllers;
use App\Http\Controllers\OrderProduct\OrderProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Product\ProductController;
use Symfony\Component\HttpFoundation\Response;

Route::group(["prefix" => "auth", 'controller' => AdminController::class],function(){
    Route::group(["prefix" => "admin"], function(){
        Route::post("login", "login")->name('admin.login');
        Route::post('logout', 'logout')->name('admin.logout')->middleware('auth:sanctum');
    });

    Route::group(['prefix' => 'user', 'controller' => UserAuthController::class], function(){
        Route::post('register', 'register')->name('user.register');
        Route::post('login', 'login')->name('user.login');
        Route::post('logout', 'logout')->name('user.logout')->middleware('auth:sanctum');
    });

});

    Route::apiResource('category', CategoryController::class)->missing(function($request){
        return response()->returnResult(response_code: Response::HTTP_NOT_FOUND,
         message: 'No Category Found Matching Id: '.$request->category,
          status: 'no');
    })->middleware('auth:sanctum');

    Route::apiResource('category.product', ProductController::class)->missing(function($request){
        return response()->returnResult(response_code: Response::HTTP_NOT_FOUND,
         message: 'No Product Found Matching Id: '.$request->product.' on Category With Id: '.$request->category,
          status: 'no');
    })->shallow()->middleware('auth:sanctum');

    Route::apiResource('cart-product', CartProductController::class)->middleware('auth:sanctum');
    
    Route::group(['prefix' => 'cart', 'middleware' => 'auth:sanctum'], function(){
        Route::get('/', [CartController::class, 'show'])->name('cart.index');
        Route::delete('clear', [CartController::class, 'clear'])->name('cart.clear');
        
        
    });
    Route::group(['middleware'=>'auth:sanctum'], function(){
        Route::get('products', [CartProductController::class, 'getProductsForCart'])->name('cart.products');
    });

    Route::group(['prefix'=>'order-product', 'middleware' => 'auth:sanctum'], function(){
        Route::get('/{order}', [OrderProductController::class, 'showOrderProducts'])->name('order-product.order');
        Route::post('/', [OrderProductController::class, 'addToCart'])->name('order-product.add');
        Route::put('/{orderProduct}', [OrderProductController::class, 'EditProduct'])->name('order-product.edit');
        Route::delete('/{orderProduct}', [OrderProductController::class, 'removeProduct'])->name('order-product.delete');
    });
    Route::group(['prefix' => 'order', 'middleware' => 'auth:sanctum'], function(){
        Route::post('/{order}/{status}', [OrderControllers::class, 'changeStatus'])->name('order.change');
        Route::delete('/{order}', [OrderControllers::class, 'deleteOrder'])->name('order.delete');
        Route::post('/create', [OrderControllers::class, 'createOrder'])->name('order.create');
    });
