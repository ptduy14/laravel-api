<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'product_name' => Str::random(5),
            'product_price' => rand(100,500),
            'product_status' => rand(0,1),
            'category_id' => rand(1, 5)
        ]);
    }
}
