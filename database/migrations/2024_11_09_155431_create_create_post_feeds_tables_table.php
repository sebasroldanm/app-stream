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
        Schema::create('post_feeds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('feed_id')->constrained('feeds')->onDelete('cascade');
            $table->timestamp('createdAt');
            $table->string('imageLink')->nullable();
            $table->text('body')->nullable();
            $table->integer('likes')->default(0);
            $table->string('accessMode')->nullable();
            $table->string('imageUrl')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_feeds');
    }
};
