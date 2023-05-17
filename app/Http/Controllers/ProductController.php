<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Exceptions\ItemDoesNotExit;
use App\Http\Requests\CreateProductRequest;
use App\Exceptions\InvalidForeignKey;
use App\Models\Category;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Models\ProductDetail;
use App\Exceptions\ForeignKeyConstraintException;

class ProductController extends Controller
{
    public function getAllProducts() {
        $products = Product::all();

        throw_if(!$products, ItemDoesNotExit::class);

        return response()->json([
            'status' => 200,
            'message' => 'The action is done successfully',
            'data' => ProductResource::collection($products)
        ]);
    }

    public function getProduct($id) {
        $product = Product::find($id);
        
        throw_if(!$product, ItemDoesNotExit::class);

        return response()->json([
            'status' => 200,
            'message' => 'The action is done successfully',
            'data' => new ProductResource($product)
        ]);
    }

    public function createProduct(CreateProductRequest $request) {
        $request->validated();

        $category = Category::find($request->input('category_id'));

        throw_if(!$category, InvalidForeignKey::class);

        $product = Product::create([
            'product_name' => $request->input('product_name'),
            'product_price' => $request->input('product_price'),
            'category_id' => $request->input('category_id')
        ]);

        return response()->json([
            'status' => 201,
            'message' => 'The item was created successfully',
            'data' => new ProductResource($product)
        ]);
    }

    public function updateProduct(UpdateProductRequest $request, $id) {
        $product = Product::find($id);
        
        throw_if(!$product, ItemDoesNotExit::class);

        $request->validated();

        $category = Category::find($request->input('category_id'));

        throw_if(!$category, InvalidForeignKey::class);

        if ($request->product_status == 1) {
            $ProductDetail = $product->detail;

            if (!$ProductDetail) {
                return response()->json([
                    'status' => 202,
                    'message' => 'cannot change becausse this product not have detail'
                ]);
            }
        }

        $product->update([
            'product_name' => $request->input('product_name'),
            'product_price' => $request->input('product_price'),
            'product_status' => $request->input('product_status'),
            'category_id' => $request->input('category_id'),
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'The action is done successfully',
            'data' => new ProductResource($product),
        ]);
    }

    public function deleteProduct($id) {
        $product = Product::find($id);
        $detail = $product->detail;

        throw_if(!$product, ItemDoesNotExit::class);
        throw_if($detail, ForeignKeyConstraintException::class);

        $product->delete();

        return response()->json([
            'status' => 204,
            'message' => 'The action is done successfully',
        ]);
    }
}
