<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_products_details', function (Blueprint $table) {
            $table->Increments('product_detail_id');
            $table->text('product_detail_intro');
            $table->text('product_detail_desc');
            $table->integer('product_detail_weight');
            $table->date('product_detail_mfg');
            $table->integer('product_detail_exp');
            $table->string('product_detail_origin');
            $table->text('product_detail_manual');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_products_details');
    }
};
