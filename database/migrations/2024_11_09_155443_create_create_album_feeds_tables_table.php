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
        Schema::create('album_feeds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('feeds')->onDelete('cascade');
            $table->timestamp('createdAt');
            $table->boolean('isDeleted')->default(false);
            $table->bigInteger('owner_id');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->integer('cost')->default(0);
            $table->string('accessMode')->nullable();
            $table->integer('photosCount')->default(0);
            $table->integer('likes')->default(0);
            $table->string('preview')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('album_feeds');
    }
};
