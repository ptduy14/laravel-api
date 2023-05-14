<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductDetail;
use App\Exceptions\ItemDoesNotExit;
use App\Exceptions\InvalidForeignKey; // exception use for if foreignKey not invalid
use App\Exceptions\ForeignKeyConstraintException; // exception use for if delete a resource have foreignKey
use App\Http\Resources\ProductDetailResource;
use App\Models\Product;
use App\Http\Requests\CreateProductDetailRequest;
use Carbon\Carbon;
use App\Exceptions\InvalidDateFormatException;
use App\Http\Requests\UpdateProductDetailRequest;

class ProductDetailController extends Controller
{
    public function getProductDetail($id) {
        $product = Product::find($id);
        $detail = $product->detail;

        throw_if(!$product, ItemDoesNotExit::class);
        throw_if(!$detail, ItemDoesNotExit::class);

        return response()->json([
            'status' => 200,
            'message' => 'The action is done successfully',
            'data' => new ProductDetailResource($detail)
        ]);
    }

    public function createProductDetail($id, CreateProductDetailRequest $request) {
        $product = Product::find($id);
        $detail = $product->detail;

        throw_if(!$product, ItemDoesNotExit::class);
        //nếu products đã có detail rồi thì bắn lỗi
        throw_if($detail, InvalidForeignKey::class);

        $request->validated();

        $dateString = $request->product_detail_mfg;
        $dateOject = Carbon::parse($dateString); // chuyển về oject dạng date
        $date = $dateOject->format('Y-m-d');

        $detailCreated = ProductDetail::create([
            'product_detail_intro' => $request->product_detail_intro,
            'product_detail_desc' => $request->product_detail_desc,
            'product_detail_weight' => $request->product_detail_weight,
            'product_detail_mfg' => $date,
            'product_detail_exp' => $request->product_detail_exp,
            'product_detail_origin' => $request->product_detail_origin,
            'product_detail_manual' => $request->product_detail_manual,
            'product_id' => $request->product_id
        ]);

        return response()->json([
            'status' => 201,
            'message' => 'The item was created successfully',
            'data' => new ProductDetailResource($detailCreated)
        ]);
    }    

    public function updateProductDetail($id, UpdateProductDetailRequest $request) {
        $product = Product::find($id);
        $detail = $product->detail;

        throw_if(!$product, ItemDoesNotExit::class);
        throw_if(!$detail, ItemDoesNotExit::class);

        $request->validated();

        $dateString = $request->product_detail_mfg;
        $dateOject = Carbon::parse($dateString); // chuyển về oject dạng date
        $date = $dateOject->format('Y-m-d');

        $detail->update([
            'product_detail_intro' => $request->product_detail_intro,
            'product_detail_desc' => $request->product_detail_desc,
            'product_detail_weight' => $request->product_detail_weight,
            'product_detail_mfg' => $date,
            'product_detail_exp' => $request->product_detail_exp,
            'product_detail_origin' => $request->product_detail_origin,
            'product_detail_manual' => $request->product_detail_manual,
            'product_id' => $request->product_id
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'The action is done successfully',
            'data' => new ProductDetailResource($detail),
        ]);
    }

    public function deleteProductDetail($id) {
        $product = Product::find($id);
        $detail = $product->detail;

        throw_if(!$detail, ItemDoesNotExit::class);

        $detail->delete();

        return response()->json([
            'status' => 204,
            'message' => 'The action is done successfully',
        ]);
    }
}
