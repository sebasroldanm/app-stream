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
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('albumId')->unsigned();
            $table->bigInteger('ownerId')->unsigned();
            $table->integer('order');
            $table->boolean('isNew');

            $table->string('url')->nullable();          // Original
            $table->string('urlThumb')->nullable();     // Miniatura
            $table->string('urlPreview')->nullable();   // Preview
            $table->string('urlThumbMicro')->nullable();// Miniatura Micro|

            $table->timestamp('createdAt');
            $table->json('data')->nullable();

            $table->foreign('albumId')->references('id')->on('albums');
            $table->foreign('ownerId')->references('id')->on('owners');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photos');
    }
};
