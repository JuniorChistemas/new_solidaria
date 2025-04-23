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
        Schema::create('product__locals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products','id');
            $table->foreignId('local_id')->constrained('categories','id');
            $table->double('StockFraction', 8, 2)->default(0.00);
            $table->double('StockBox', 8, 2);
            $table->smallInteger('stock_min')->default(0);
            $table->smallInteger('stock_max')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product__locals');
    }
};
