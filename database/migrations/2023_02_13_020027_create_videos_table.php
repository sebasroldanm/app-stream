<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();

            $table->integer('idVideo');
            $table->string('username');
            $table->timestamp('createdAt')->nullable();
            $table->boolean('isDeleted')->nullable();
            $table->integer('userId')->nullable();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('accessMode')->nullable();
            $table->integer('duration')->nullable();
            $table->text('trailerUrl')->nullable();
            $table->text('coverUrl')->nullable();
            $table->text('microCoverUrl')->nullable();
            $table->integer('likes')->nullable();
            $table->text('videoUrl')->nullable();
            $table->boolean('isHls')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
};
