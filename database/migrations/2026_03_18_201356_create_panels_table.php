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
        Schema::create('panels', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('body');
            $table->string('imageUrl');
            $table->foreignId('owner_id')->constrained('owners')->cascadeOnDelete();
            $table->integer('order')->nullable();
            $table->integer('column')->nullable();
            $table->json('data');
            $table->timestamp('createdAt')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('panels');
    }
};
