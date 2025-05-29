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
        Schema::create('rent_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_contract_id')->constrained();
            $table->date('due_date');
            $table->date('payment_date')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('payment_reference');
            $table->enum('payment_method',['cash','wave','om','momo','moov','bank'])->default('cash');
            $table->enum('status', ['pending', 'paid', 'late'])->default('pending');
            $table->string('notes');
            $table->softDeletes();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rent_payments');
    }
};
