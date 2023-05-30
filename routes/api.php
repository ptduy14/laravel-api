<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\CartController;
use App\Http\Resources\UserResource;
use App\Http\Controllers\OrderController;

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

// use for OAuth2
Route::get('/user', function (Request $request) {
    return response()->json([
        'status' => 200,
        'message' => 'get user infomation successfully',
        'data' => new UserResource($request->user())
    ]);
})->middleware('auth:api');

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:jwt')->group(function () {

    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::put('/users/{id}', [UserController::class, 'updateUser']);
    Route::get('/users/{id}/profile', [AuthController::class, 'profile']);

    Route::middleware('role:super-admin')->group(function() {
        Route::put('/users/{id}/roles', [UserController::class, 'updateUserRole']);
        Route::delete('/users/{id}', [UserController::class, 'deleteUser']);
    });

    Route::middleware('role:admin|super-admin')->group(function() {
        //user
        Route::get('/users', [UserController::class, 'getAllUsers']);
        Route::get('/users/{id}', [UserController::class, 'getUser']);
        Route::post('/users', [UserController::class, 'createUser']);

        //category
        Route::post('/categories', [CategoryController::class, 'createCategory']);
        Route::put('/categories/{id}', [CategoryController::class, 'updateCategory']);
        Route::delete('/categories/{id}', [CategoryController::class, 'deleteCategory']);

        //product
        Route::post('/products', [ProductController::class, 'createProduct']);
        Route::put('/products/{id}', [ProductController::class, 'updateProduct']);
        Route::delete('/products/{id}', [ProductController::class,'deleteProduct']);

        //product-detail
        Route::post('/products/{id}/details', [ProductDetailController::class, 'createProductDetail']);
        Route::put('/products/{id}/details', [ProductDetailController::class, 'updateProductDetail']);
        Route::delete('/products/{id}/details', [ProductDetailController::class, 'deleteProductDetail']);
    });

    Route::middleware('role:user')->group(function() {
        Route::get('/users/{id}/orders', [OrderController::class, 'getOrders']);
        Route::get('/users/{id}/orders/{id_order}', [OrderController::class, 'getOrder']);
        Route::post('/users/{id}/orders', [OrderController::class, 'paymentOrder']);
        Route::put('/users/{id}/orders/{id_order}', [OrderController::class, 'updateOrderStatus']);

    });
});

Route::get('/users/{id}/carts', [CartController::class, 'getCart']);
Route::post('/users/{id}/carts/products/{id_product}', [CartController::class, 'addProductCartItem']);
Route::delete('/users/{id}/carts/products/{id_product}', [CartController::class,'deleteProductCartItem']);
Route::put('/users/{id}/carts/products/{id_product}', [CartController::class,'updateProductCartItem']);

Route::get('/categories', [CategoryController::class, 'getAllCategory']);
Route::get('/categories/{id}', [CategoryController::class, 'getCategory']);
Route::get('/categories/{id}/products', [CategoryController::class, 'getProductsOfCategory']);

Route::get('/products', [ProductController::class, 'getAllProducts']);
Route::get('/products/{id}', [ProductController::class, 'getProduct']);
Route::get('/products/{id}/details', [ProductDetailController::class, 'getProductDetail']);
