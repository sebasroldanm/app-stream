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
        Schema::create('photo_album_feeds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('album_feed_id')->constrained('album_feeds')->onDelete('cascade');
            $table->timestamp('createdAt')->nullable();
            $table->boolean('isDeleted')->default(false);
            $table->bigInteger('album_id')->nullable();
            $table->integer('order')->nullable();
            $table->string('status')->nullable();
            $table->boolean('isNew')->default(false);
            $table->string('primaryColor')->nullable();
            $table->string('source')->nullable();
            $table->string('url')->nullable();
            $table->string('urlThumb')->nullable();
            $table->string('urlPreview')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photo_album_feeds');
    }
};
