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
        Schema::create('video_feeds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('feed_id')->constrained('feeds')->onDelete('cascade');
            $table->bigInteger('owner_id');
            $table->timestamp('createdAt');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('cost')->nullable();
            $table->string('format')->nullable();
            $table->string('accessMode')->nullable();
            $table->integer('duration')->nullable();
            $table->string('trailerUrl')->nullable();
            $table->string('coverUrl')->nullable();
            $table->string('microCoverUrl')->nullable();
            $table->integer('likes')->default(0);
            $table->text('coverUrls')->nullable();
            $table->string('videoUrl')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_feeds');
    }
};
