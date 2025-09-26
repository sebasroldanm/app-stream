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
            $table->string('id', 20)->primary();
            $table->string('deletehash');
            $table->string('account_id');
            $table->string('account_url');
            $table->string('display_url')->nullable();
            $table->string('ad_type')->nullable();
            $table->string('ad_url')->nullable();
            $table->string('title');
            $table->string('description');
            $table->string('name');
            $table->string('type');
            $table->string('width');
            $table->string('height');
            $table->string('size');
            $table->string('views');
            $table->string('section')->nullable();
            $table->string('vote')->nullable();
            $table->string('bandwidth');
            $table->string('animated')->nullable();
            $table->string('favorite')->nullable();
            $table->string('in_gallery')->nullable();
            $table->string('in_most_viral')->nullable();
            $table->string('has_sound')->nullable();
            $table->string('is_ad')->nullable();
            $table->string('nsfw')->nullable();
            $table->string('link');
            $table->string('tags')->nullable();
            $table->string('datetime');
            $table->string('mp4')->nullable();
            $table->string('hls')->nullable();

            $table->string('is_album')->nullable()->index();
            
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
