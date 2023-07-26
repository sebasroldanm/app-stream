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
        Schema::create('albums', function (Blueprint $table) {
            $table->id();

            $table->integer('albumId');
            $table->integer('userId');
            $table->timestamp('createdAt')->nullable();
            $table->boolean('isDeleted')->nullable();
            $table->string('accessMode')->nullable();
            $table->string('isReserved')->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->text('preview')->nullable();
            $table->text('previewUnverified')->nullable();
            $table->text('previewMicro')->nullable();
            $table->integer('photosCount')->nullable();


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
        Schema::dropIfExists('albums');
    }
};
