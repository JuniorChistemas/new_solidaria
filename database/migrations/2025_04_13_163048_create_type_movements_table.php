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
        Schema::create('type_movements', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('serie', 40)->nullable(); // Serie Movimeinto Ej. B0001 , G0001 , F0001  , etc.
            $table->integer('correlativo')->default(0);
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_movements');
    }
};
