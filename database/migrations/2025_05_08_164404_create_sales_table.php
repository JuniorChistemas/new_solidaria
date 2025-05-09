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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users', 'id');
            $table->foreignId('customer_id')->constrained('customers', 'id');
            $table->foreignId('local_id')->constrained('locals', 'id');
            $table->foreignId('type_voucher_id')->constrained('type_vouchers', 'id');
            $table->foreignId('type_payment_id')->constrained('type_payments', 'id');
            $table->foreignId('doctor_id')->constrained('doctors', 'id')->nullable();
            $table->string('code')->unique();
            $table->string('code_card')->nullable();
            $table->double('op_gravada', 10, 2);
            $table->double('op_exonerada', 10, 2)->default(0);
            $table->double('op_inafecta', 10, 2)->default(0);
            $table->double('igv', 10, 2);
            $table->double('total', 10, 2);
            $table->boolean('status_sale')->default(true);
            $table->boolean('state_sunat')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
