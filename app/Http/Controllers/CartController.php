<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\CartResource;
use App\Exceptions\ItemDoesNotExit;
use App\Models\Product;
use App\Models\Cart;
use App\Http\Requests\UpdateProductCartItemRequest;

class CartController extends Controller
{
    public function getCart($id) {
        $user = User::find($id);

        throw_if(!$user, ItemDoesNotExit::class);

        if (!$user->cart) {
            return response()->json([
                'status' => 200,
                'message' => 'user not have any product in cart'
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'The action is done successfully',
            'data' => new CartResource($user->cart)
        ]);
    }

    public function addProductCartItem($id, $id_product, Request $request) {
        $user = User::find($id);
        $product = Product::find($id_product);
        $quantity = $request->quantity ? $request->quantity : 1;

        throw_if(!$user, ItemDoesNotExit::class);
        throw_if(!$product, ItemDoesNotExit::class);

        $cart = $user->cart;

        if (!$cart) {
            $cart = Cart::create([
                'user_id' => $id,
                'total_quantity' => $quantity,
                'total_price' => $product->product_price * $quantity,
            ]);

            $cart->products()->attach($id_product, ['quantity' =>  $quantity]);
        } else {
            $cart->update([
                'total_quantity' => $cart->total_quantity + $quantity,
                'total_price' => $cart->total_price + $product->product_price * $quantity,
            ]);

            $productExists = $cart->products()->find($id_product);

            if ($productExists) {
                $cart->products()->updateExistingPivot($id_product, ['quantity' => $productExists->pivot->quantity + $quantity]);   
            } else {
                $cart->products()->attach($id_product, ['quantity' => $quantity]);
            }
        }

        return response()->json([
            'status' => 201,
            'messege' => 'New product has been successfully added to cart',
            'data' => new CartResource($cart)
        ]);
    }

    public function deleteProductCartItem($id, $id_product) {
        $user = User::find($id);
        $product = Product::find($id_product);

        throw_if(!$user, ItemDoesNotExit::class);
        throw_if(!$product, ItemDoesNotExit::class);

        $cart = $user->cart;

        if (!$cart) {
            return response()->json([
                'status' => 200,
                'message' => 'user not have any product in cart'
            ]);
        }

        $cart->update([
            'total_quantity' =>  $cart->total_quantity - $cart->products()->find($id_product)->pivot->quantity,
            'total_price' => $cart->total_price - $cart->products()->find($id_product)->pivot->quantity * $product->product_price
        ]);

        $cart->products()->detach($id_product);

        return response()->json([
            'status' => 204,
            'message' => 'Product has been successfully removed to cart',
        ]);
    }

    public function updateProductCartItem($id, $id_product, UpdateProductCartItemRequest $request) {
        $user = User::find($id);
        $product = Product::find($id_product);

        throw_if(!$user, ItemDoesNotExit::class);
        throw_if(!$product, ItemDoesNotExit::class);

        $cart = $user->cart;

        $request->validated;

        if(!$cart) {
            return response()->json([
                'status' => 200,
                'message' => 'user not have any product in cart'
            ]);
        }

        $cartProductItem = $cart->products()->find($id_product);
        $newQuantity = $request->quantity - $cartProductItem->pivot->quantity;

        if ($newQuantity !== 0) {
            $cart->products()->updateExistingPivot($id_product, ['quantity' => $cartProductItem->pivot->quantity + $newQuantity]);

            $cart->update([
                'total_quantity' =>  $cart->total_quantity + $newQuantity,
                'total_price' => $cart->total_price + $product->product_price * $newQuantity
            ]);      
        }

        return response()->json([
            'status' => 200,
            'message' => 'the action is done successfully',
            'data' =>  new CartResource($cart),
        ]);
    }
}
