<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movements', function (Blueprint $table) {
            $table->id();
            $table->string('code', 15);
            $table->date('issue_date');
            $table->date('credit_date')->nullable();
            
            // Relationships
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('type_movement_id')->default(1)->comment('1 invoice, 2 guide, 3 receipt, 4 sale');
            
            // Foreign keys
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('type_movement_id')->references('id')->on('type_movements')->onDelete('cascade');
            
            $table->unsignedTinyInteger('status')->default(1)->comment('0 eliminado, 1 activo, 2 anulado');
            $table->unsignedTinyInteger('igv_status')->default(1)->comment('1 incluye, 2 no incluye');
            $table->enum('payment_type', ['contado','credito'])->default('cash');
            $table->timestamps();
        });
    }
    

    public function down(): void
    {
        Schema::dropIfExists('movements');
    }
};
