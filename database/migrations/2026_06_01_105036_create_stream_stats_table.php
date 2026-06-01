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
        Schema::create('stream_stats', function (Blueprint $table) {
            $table->bigIncrements('id')->primary();
            $table->foreignId('owner_id')->constrained('owners');
            $table->integer('guests')->default(0);
            $table->integer('spies')->default(0);
            $table->integer('invisibles')->default(0);
            $table->integer('greens')->default(0);
            $table->integer('golds')->default(0);
            $table->integer('regulars')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stream_stats');
    }
};
