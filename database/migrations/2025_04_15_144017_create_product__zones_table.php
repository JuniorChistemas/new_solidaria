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
        Schema::create('product__zones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products','id');
            $table->foreignId('zone_id')->constrained('zones','id');
            $table->decimal('purchase_price', 8, 2);
            $table->decimal('percentage', 8, 2);
            $table->decimal('unit_price', 8, 2);
            $table->decimal('fraction_price', 8, 2);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product__zones');
    }
};
