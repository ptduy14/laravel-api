<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class ProductDetail extends Model
{
    use HasFactory;

    protected $table='tbl_product_details';
    protected $primaryKey='product_detail_id';
    protected $fillable = [
        'product_detail_intro',
        'product_detail_desc',
        'product_detail_weight',
        'product_detail_mfg',
        'product_detail_exp',
        'product_detail_origin',
        'product_detail_manual',
        'product_id'
    ];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
