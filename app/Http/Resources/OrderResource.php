<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'order_id' => $this->order_id,
            'reciver' => $this->reciver,
            'phone' => $this->phone,
            'address' => $this->address,
            'total_money' => $this->total_money,
            'order_date' => $this->order_date,
            'order_status' => $this->order_status,
            'method_payment' => $this->method_payment,
            'total_quantity' => $this->total_quantity,
            'products' => $products
        ];
    }
}
