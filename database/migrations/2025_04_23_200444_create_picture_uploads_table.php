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
        Schema::create('picture_uploads', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('title');
            $table->string('url_viewer');
            $table->string('url');
            $table->string('display_url');
            $table->integer('width');
            $table->integer('height');
            $table->integer('size');
            $table->bigInteger('time');
            $table->integer('expiration');
            
            // Imagen original
            $table->string('image_filename')->nullable();
            $table->string('image_name')->nullable();
            $table->string('image_mime')->nullable();
            $table->string('image_extension', 10)->nullable();
            $table->string('image_url')->nullable();
            
            // Thumbnail
            $table->string('thumb_filename')->nullable();
            $table->string('thumb_name')->nullable();
            $table->string('thumb_mime')->nullable();
            $table->string('thumb_extension', 10)->nullable();
            $table->string('thumb_url')->nullable();
            
            // Medium
            $table->string('medium_filename')->nullable();
            $table->string('medium_name')->nullable();
            $table->string('medium_mime')->nullable();
            $table->string('medium_extension', 10)->nullable();
            $table->string('medium_url')->nullable();
            
            $table->string('delete_url');
            $table->boolean('success')->nullable();
            $table->integer('status')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('picture_uploads');
    }
};
