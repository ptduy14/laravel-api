<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\CartController;

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

Route::middleware('auth:api')->group(function() {
    // this route for OAuth2 Client get data of current user
    Route::get('oauth/user', function(Request $request) {
        return $request->user();
    })->middleware('scopes:oauth-data-scope');

    // this group for internal system
    Route::middleware('forbid:oauth-data-scope')->group(function() {
        Route::get('/logout', [AuthController::class, 'logout']);
    });
});


Route::middleware('role:admin')->group(function() {
    Route::get('/tests', function() {
        return 'ok';
    });
});

Route::get('/users', [UserController::class, 'getAllUsers']);
Route::get('/users/{id}', [UserController::class, 'getUser']);
Route::post('/users', [UserController::class, 'createUser']);
Route::put('/users/{id}', [UserController::class, 'updateUser']);
Route::delete('/users/{id}', [UserController::class, 'deleteUser']);

Route::get('/users/{id}/carts', [CartController::class, 'getCart']);
Route::post('/users/{id}/carts/products/{id_product}', [CartController::class, 'addProductCartItem']);
Route::delete('/users/{id}/carts/products/{id_product}', [CartController::class,'deleteProductCartItem']);
Route::put('/users/{id}/carts/products/{id_product}', [CartController::class,'updateProductCartItem']);

Route::get('/categories', [CategoryController::class, 'getAllCategory']);
Route::get('/categories/{id}', [CategoryController::class, 'getCategory']);
Route::post('/categories', [CategoryController::class, 'createCategory']);
Route::put('/categories/{id}', [CategoryController::class, 'updateCategory']);
Route::delete('/categories/{id}', [CategoryController::class, 'deleteCategory']);
Route::get('/categories/{id}/products', [CategoryController::class, 'getProductsOfCategory']);

Route::get('/products', [ProductController::class, 'getAllProducts']);
Route::get('/products/{id}', [ProductController::class, 'getProduct']);
Route::post('/products', [ProductController::class, 'createProduct']);
Route::put('/products/{id}', [ProductController::class, 'updateProduct']);
Route::delete('/products/{id}', [ProductController::class,'deleteProduct']);

Route::get('/products/{id}/details', [ProductDetailController::class, 'getProductDetail']);
Route::post('/products/{id}/details', [ProductDetailController::class, 'createProductDetail']);
Route::put('/products/{id}/details', [ProductDetailController::class, 'updateProductDetail']);
Route::delete('/products/{id}/details', [ProductDetailController::class, 'deleteProductDetail']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


