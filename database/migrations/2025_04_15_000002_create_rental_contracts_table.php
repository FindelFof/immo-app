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
        Schema::create('rental_contracts', function (Blueprint $table) {
            $table->id();
            $table->string('contract_number')->unique();
            $table->foreignId('property_id')->constrained('properties');
            $table->foreignId('tenant_id')->constrained('users');
            $table->date('contract_date');
            $table->date('start_date');
            $table->date('end_date');
            $table->date('final_end_date')->nullable();
            $table->decimal('monthly_rent', 10, 2);
            $table->decimal('deposit', 10, 2);
            $table->enum('status', ['active', 'terminated', 'expired'])->default('active');
            $table->json('others_fees')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_contracts');
    }
};
