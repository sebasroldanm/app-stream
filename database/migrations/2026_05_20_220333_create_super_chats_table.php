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
        Schema::create('super_chats', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->foreignId('owner_id')->constrained('owners');
            $table->timestamp('createdAt');
            $table->boolean('isDeleted');
            $table->string('cacheId', 34);
            $table->string('type', 30);
            $table->json('details');
            $table->json('userData');
            $table->json('additionalData');
            $table->timestamps();

            $table->index(['owner_id', 'createdAt']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('super_chats');
    }
};
