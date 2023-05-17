<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;

class Cart extends Model
{
    use HasFactory;
    protected $table='tbl_carts';
    protected $primaryKey = 'cart_id';
    protected $fillable = [
        'total_price',
        'total_quantity',
        'user_id'
    ];

    public function user() {
       return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function products() {
        return $this->belongsToMany(Product::class, 'cart_product', 'cart_id', 'product_id')->withPivot('quantity');
    }
}
