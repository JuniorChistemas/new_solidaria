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
            $table->id();
            $table->string('name');
            $table->string('composition', 400)->nullable();
            $table->string('presentation', 100)->nullable();
            $table->string('form_farm', 200)->nullable();
            $table->string('barcode', 13)->nullable();
            $table->foreignId('laboratory_id')->constrained('laboratories', 'id');
            $table->foreignId('category_id')->constrained('categories', 'id');
            $table->smallInteger('fraction')->default(1);
            $table->boolean('state_fraction')->default(true)->comment('true: fraccionable, false: no fraccionable');
            $table->boolean('state_igv')->default(true)->comment('true: afectado, false: inafectado');
            $table->boolean('state')->default(true)->comment('true: activo, false: inactivo');
            $table->timestamps();
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
