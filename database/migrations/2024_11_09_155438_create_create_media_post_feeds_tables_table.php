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
        Schema::create('media_post_feeds', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->foreignId('post_feed_id')->constrained('post_feeds')->onDelete('cascade');
            $table->string('type');
            $table->bigInteger('data_id');
            $table->timestamp('createdAt');
            $table->bigInteger('albumId');
            $table->integer('order')->nullable();
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
        Schema::dropIfExists('media_post_feeds');
    }
};
