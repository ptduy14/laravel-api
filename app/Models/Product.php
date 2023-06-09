<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\ProductDetail;
use App\Models\Order;
use App\Models\Cart;

class Product extends Model
{
    use HasFactory;
    protected $table = 'tbl_products';
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'product_name',
        'product_price',
        'product_status',
        'category_id'
    ];

    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function detail() {
        return $this->hasOne(ProductDetail::class, 'product_id', 'product_id');
    }

    public function orders() {
        return $this->belongsToMany(Order::class, 'order_product', 'product_id', 'order_id')->withPivot('quantity');
    }

    public function carts() {
        return $this->belongsToMany(Cart::class, 'cart_product', 'product_id', 'cart_id')->withPivot('quantity');
    }
}
