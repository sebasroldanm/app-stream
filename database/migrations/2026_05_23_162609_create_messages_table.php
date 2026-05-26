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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('conversation_id');
            $table->string('kind')->nullable();
            $table->timestamp('createdAt')->nullable();
            $table->unsignedBigInteger('senderId')->nullable();
            $table->unsignedBigInteger('recipientId')->nullable();
            $table->string('type')->nullable();
            $table->text('body')->nullable();
            $table->string('mediaType')->nullable();
            $table->json('mediaId')->nullable();
            $table->boolean('isRead')->default(false);
            $table->timestamps();

            $table->foreign('conversation_id')->references('id')->on('conversations')->onDelete('cascade');

            $table->index(['conversation_id', 'createdAt']);
            $table->index(['conversation_id', 'updated_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
