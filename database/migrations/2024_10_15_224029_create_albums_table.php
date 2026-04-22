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
        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('owner_id')->unsigned();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('accessMode')->nullable();
            $table->integer('photosCount')->nullable();
            $table->integer('likes');
            $table->timestamp('createdAt');
            $table->json('data')->nullable();
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('owners');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('albums');
    }
};
