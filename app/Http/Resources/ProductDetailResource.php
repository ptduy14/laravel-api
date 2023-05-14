<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product_detail_id' => $this->product_detail_id,
            'product_detail_intro' => $this->product_detail_intro,
            'product_detail_desc' => $this->product_detail_desc,
            'product_detail_weight' => $this->product_detail_weight,
            'product_detail_mfg' => $this->product_detail_mfg,
            'product_detail_exp' => $this->product_detail_exp,
            'product_detail_origin' => $this->product_detail_origin,
            'product_detail_manual' => $this->product_detail_manual,
            'product_id' => $this->product_id    
        ];
    }
}
