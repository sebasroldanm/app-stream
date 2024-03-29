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
        Schema::create('intros', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('url');
            $table->foreignId('owner_id')->constrained('owners')->cascadeOnDelete();
            $table->json('data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intros');
    }
};
