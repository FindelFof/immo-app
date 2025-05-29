<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users');
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->enum('type', ['sale', 'rent']);
            $table->enum('property_type', ['house', 'apartment', 'land', 'commercial']);
            $table->string('city');
            $table->string('address');
            $table->integer('rooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->decimal('surface', 10, 2)->nullable();
            $table->json('features')->nullable();
            $table->boolean('is_available')->default(true);
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->year('year_built')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->enum('status', ['available', 'pending', 'sold', 'rented'])->default('available');
            $table->string('neighborhood')->nullable();
            $table->string('postal_code')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
