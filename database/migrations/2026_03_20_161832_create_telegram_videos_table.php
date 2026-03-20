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
        Schema::create('telegram_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fk_telegram_messages_id')->constrained('telegram_messages')->onDelete('cascade');

            // Video
            $table->integer('duration')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('file_name')->nullable();
            $table->string('mime_type')->nullable();
            $table->string('file_id');
            $table->string('file_unique_id');
            $table->bigInteger('file_size')->nullable();
            
            // Thumbnail
            $table->string('thumbnail_file_id')->nullable();
            $table->string('thumbnail_file_unique_id')->nullable();
            $table->integer('thumbnail_file_size')->nullable();
            $table->integer('thumbnail_width')->nullable();
            $table->integer('thumbnail_height')->nullable();
            
            // Thumb
            $table->string('thumb_file_id')->nullable();
            $table->string('thumb_file_unique_id')->nullable();
            $table->integer('thumb_file_size')->nullable();
            $table->integer('thumb_width')->nullable();
            $table->integer('thumb_height')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telegram_videos');
    }
};
