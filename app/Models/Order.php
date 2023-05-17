<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;

class Order extends Model
{
    use HasFactory;

    protected $table = 'tbl_orders';
    protected $primaryKey = 'order_id';
    protected $fillable = [
        'reciver',
        'phone',
        'address',
        'total_money',
        'order_date',
        'order_status',
        'method_payment',
        'total_quantity',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function products() {
        return $this->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id')->withPivot('quantity');
    }
}
