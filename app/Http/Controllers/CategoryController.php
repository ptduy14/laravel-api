<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Exceptions\ItemDoesNotExit;
use App\Exceptions\ForeignKeyConstraintException;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\ProductsOfCategoryResource;

class CategoryController extends Controller
{
    public function getAllCategory() {
        $categories = Category::all();

        throw_if(!$categories, ItemDoesNotExit::class);

        return response()->json([
            'status' => 200,
            'message' => 'The action is done successfully',
            'data' => CategoryResource::collection($categories)
        ]);
    }

    public function getCategory($id) {
        $category = Category::find($id);

        throw_if(!$category, ItemDoesNotExit::class);

        return response()->json([
            'status' => 200,
            'message' => 'The action is done successfully',
            'data' => new CategoryResource($category)
        ]);
    }

    public function createCategory(CreateCategoryRequest $request) {
        $request->validated();

        $category = Category::create([
            'category_name' => $request->input('category_name'),
            'category_desc' => $request->input('category_desc')
        ]);
        
        return response()->json([
            'status' => 201,
            'message'=> 'The item was created successfully',
            'data' =>  new CategoryResource($category),
        ]);
    }

    public function updateCategory(UpdateCategoryRequest $request, $id) {
        $category = Category::find($id);

        throw_if(!$category, ItemDoesNotExit::class);

        $request->validated();

        $category->update([
            'category_name' => $request->input('category_name'),
            'category_desc' => $request->input('category_desc'),
            'category_status' => $request->input('category_status')
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'the action is done successfully',
            'data' =>  new CategoryResource($category),
        ]);
    }

    public function deleteCategory($id) {
        $category = Category::find($id);

        throw_if(!$category, ItemDoesNotExit::class);

        $productsOfCategory = $category->products;

        throw_if($productsOfCategory, ForeignKeyConstraintException::class);

        return response()->json([
            'status' => 204,
            'message' => 'The action is done successfully',
        ]); 
    }

    public function getProductsOfCategory($id) {
        $category = Category::find($id);

        throw_if(!$category, ItemDoesNotExit::class);

        return response()->json([
            'status' => 200,
            'message' => 'The action is done successfully',
            'category_id' => $category->category_id, 
            'data' => ProductsOfCategoryResource::collection($category->products)
        ]);
    }
}
