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
        Schema::table('products_specs', function (Blueprint $table) {
            $table->string('Model')->nullable()->after('Processor');
            $table->string('Display')->nullable();
            $table->string('Battery')->nullable();
            $table->string('Warranty')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('products_specs', function (Blueprint $table) {
            $table->dropColumn(['Model', 'Display', 'Battery', 'Warranty']);
        });
    }
};
