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
        Schema::create('sunat_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('sales', 'id');
            $table->string('file_name');
            $table->string('file_path_xml');
            $table->string('file_path_cdr')->nullable();
            $table->enum('status', ['pendiente', 'aceptado', 'rechazado', 'observado', 'anulado'])->default('pending');
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sunat_logs');
    }
};
