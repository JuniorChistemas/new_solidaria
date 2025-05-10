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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 11)->unique();
            $table->string('firstname', 50);
            $table->string('lastname', 80);
            $table->string('address', 100)->nullable();
            $table->string('phone', 9)->nullable();
            $table->timestamp('birthdate')->nullable();
            $table->foreignId('client_type_id')->constrained('client_types', 'id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
