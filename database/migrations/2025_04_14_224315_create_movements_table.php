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
            $table->string('codigo', 15);
            $table->date('fechaEmision');
            $table->date('fechaEjecucion');
            $table->date('fechaCredito')->nullable();
            
            // Relaciones
            $table->unsignedBigInteger('idProveedor');
            $table->unsignedBigInteger('idLocal');
            $table->unsignedBigInteger('idUser');
    
            // Foreign keys
            $table->foreign('idProveedor')->references('id')->on('suppliers')->onDelete('cascade');
            $table->foreign('idLocal')->references('id')->on('locals')->onDelete('cascade');
            $table->foreign('idUser')->references('id')->on('users')->onDelete('cascade');
    
            $table->unsignedTinyInteger('idTipoMovimiento')->default(1)->comment('1 factura, 2 guía, 3 boleta, 4 es venta');
            $table->unsignedTinyInteger('estado')->default(1)->comment('0 eliminado, 1 activo, 2 anulado');
            $table->unsignedTinyInteger('estadoIgv')->default(1)->comment('1 incluye, 2 no incluye');
            $table->unsignedTinyInteger('estadoIngreso')->default(1)->comment('1 es ingreso, 0 es salida');
            $table->enum('tipoPago', ['contado','credito'])->default('contado');
            $table->timestamps();
        });
    }
    

    public function down(): void
    {
        Schema::dropIfExists('movements');
    }
};
