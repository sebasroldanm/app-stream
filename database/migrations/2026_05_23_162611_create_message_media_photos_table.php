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
        Schema::create('message_media_photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('message_media_id');
            $table->timestamp('createdAt')->nullable();
            $table->boolean('isDeleted')->default(false);
            $table->unsignedBigInteger('albumId')->nullable();
            $table->string('aspectRatio')->nullable();
            $table->integer('order')->nullable();
            $table->string('status')->nullable();
            $table->text('urlThumbMicro')->nullable();
            $table->boolean('isNew')->default(false);
            $table->string('primaryColor')->nullable();
            $table->string('source')->nullable();
            $table->string('isNudeContent')->nullable();
            $table->boolean('isInCollection')->default(false);
            $table->boolean('isUnderPreModeration')->default(false);
            $table->text('rejectReason')->nullable();
            $table->text('url')->nullable();
            $table->text('urlThumb')->nullable();
            $table->text('urlPreview')->nullable();
            $table->boolean('isBought')->default(false);
            $table->string('type')->nullable();
            $table->timestamps();

            $table->foreign('message_media_id')->references('id')->on('message_media')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_media_photos');
    }
};
