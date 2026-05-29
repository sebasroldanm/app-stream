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
        Schema::create('goals', function (Blueprint $table) {

            $table->id();
            $table->foreignId('owner_id')->constrained('owners');
            $table->string('description');
            $table->integer('goal')->default(0);
            $table->integer('spent')->default(0);
            $table->boolean('isEnabled')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['owner_id', 'isEnabled']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goals');
    }
};
