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
        Schema::create('products_specs', function (Blueprint $table) {
            $table->bigIncrements('spec_id');
            $table->string('Processor')->nullable();
            $table->string('Ram')->nullable();
            $table->string('Graphics_Card')->nullable();
            $table->string('System_type')->nullable();
            $table->string('Pen_and_touch')->nullable();
            $table->string('Storage')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_specs');
    }
};
