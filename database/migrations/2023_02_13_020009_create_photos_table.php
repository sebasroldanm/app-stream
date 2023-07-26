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
        Schema::create('photos', function (Blueprint $table) {
            $table->id();

            $table->integer('photoId');
            $table->integer('albumId');
            $table->integer('userId');
            $table->timestamp('createdAt')->nullable();
            $table->boolean('isDeleted')->nullable();
            $table->string('aspectRatio')->nullable();
            $table->integer('order')->nullable();
            $table->string('primaryColor')->nullable();
            $table->text('urlThumbMicro')->nullable();
            $table->text('url')->nullable();
            $table->text('urlThumb')->nullable();
            $table->text('urlPreview')->nullable();


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
        Schema::dropIfExists('photos');
    }
};
