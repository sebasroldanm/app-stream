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
        Schema::create('customer_owner_favorites', function (Blueprint $table) {
            // $table->id();
            $table->unsignedBigInteger('customer_id'); // Relación con el cliente
            $table->unsignedBigInteger('owner_id');    // Relación con el propietario
            $table->timestamps();

            // Llaves foráneas
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('owner_id')->references('id')->on('owners')->onDelete('cascade');

            // Evitar duplicados
            $table->unique(['customer_id', 'owner_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_owner_favorites');
    }
};
