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
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('product_id');
            $table->string('sku')->unique();
            $table->string('product_name');
            $table->text('product_description')->nullable();
            $table->bigInteger('product_price'); 
            $table->string('product_image')->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('spec_id');
            $table->unsignedBigInteger('offer_id')->nullable();
            $table->timestamps();

        // now is no constraints)
        // $table->foreign('brand_id')->references('brand_id')->on('brands')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
