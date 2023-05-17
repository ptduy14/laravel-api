<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $products = $this->products->map(function ($product) {
            return [
                'product_id' => $product->product_id,
                'product_name' => $product->product_name,
                'product_price' => $product->product_price,
                'quantity' => $product->pivot->quantity,
            ];
        });

        return [
            'cart_id' => $this->cart_id,
            'total_quantity' => $this->total_quantity,
            'total_price' => $this->total_price,
            'products' => $products
        ];
    }
}
