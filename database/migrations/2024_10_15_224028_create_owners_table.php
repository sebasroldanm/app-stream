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
        Schema::create('owners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username');
            $table->string('previousUsername')->nullable();
            $table->string('lastUsername')->nullable();
            $table->string('avatar')->nullable();
            $table->text('preview')->nullable();
            $table->string('gender')->nullable();
            $table->string('country')->nullable();
            $table->boolean('isMobile')->default(false);
            $table->timestamp('statusChangedAt')->nullable();
            $table->boolean('isLive')->default(false);
            $table->boolean('isOnline')->nullable();
            $table->boolean('isError')->default(false);
            $table->boolean('isDelete')->default(false);
            $table->boolean('isInfoCustom')->default(false);
            $table->boolean('isMediaCustom')->default(false);
            $table->json('data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('owners');
    }
};
