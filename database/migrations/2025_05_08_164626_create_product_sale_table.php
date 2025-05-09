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
        Schema::create('product_sale', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('sales', 'id');
            $table->foreignId('product_local_id')->constrained('product_locals', 'id');
            $table->tinyInteger('quantity_box')->default(0);
            $table->tinyInteger('quantity_fraction')->default(0);
            $table->double('price_box', 10, 2)->default(0);
            $table->double('price_fraction', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_sale');
    }
};
