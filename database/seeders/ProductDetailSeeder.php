<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductDetail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProductDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductDetail::create([
            'product_detail_intro' => Str::random(5),
            'product_detail_desc' => Str::random(5),
            'product_detail_weight' => Str::random(5),
            'product_detail_mfg' => rand(1,20),
            'product_detail_exp' => Carbon::now()->subYears(1)->subMonths(1, 12),
            'product_detail_origin' => Str::random(5),
            'product_detail_manual' => Str::random(10)
        ]);
    }
}
