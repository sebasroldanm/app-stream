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
        Schema::create('message_media_videos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('message_media_id');
            $table->timestamp('createdAt')->nullable();
            $table->boolean('isDeleted')->default(false);
            $table->unsignedBigInteger('userId')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->integer('cost')->default(0);
            $table->string('minFanClubTier')->nullable();
            $table->string('accessMode')->nullable();
            $table->integer('duration')->nullable();
            $table->json('presets')->nullable();
            $table->text('trailerUrl')->nullable();
            $table->text('coverUrl')->nullable();
            $table->text('microCoverUrl')->nullable();
            $table->text('fullCoverUrl')->nullable();
            $table->integer('viewsCount')->default(0);
            $table->integer('showId')->nullable();
            $table->string('streamSpecificId')->nullable();
            $table->string('type')->nullable();
            $table->integer('likes')->default(0);
            $table->boolean('liked')->default(false);
            $table->boolean('isInCollection')->default(false);
            $table->boolean('isIntro')->default(false);
            $table->json('introUrls')->nullable();
            $table->boolean('isHls')->default(false);
            $table->boolean('isDvr')->default(false);
            $table->boolean('isVr')->default(false);
            $table->boolean('isPixelated')->default(false);
            $table->json('vrCameraSettings')->nullable();
            $table->boolean('isXConverter')->default(false);
            $table->float('aspectRatio')->nullable();
            $table->string('primaryColor')->nullable();
            $table->timestamps();

            $table->foreign('message_media_id')->references('id')->on('message_media')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_media_videos');
    }
};
