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
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('counterpartId')->nullable();
            $table->integer('unread')->default(0);
            $table->boolean('isBookmark')->default(false);
            $table->boolean('hasTokens')->default(false);
            $table->boolean('hasUnreadWithTokens')->default(false);
            $table->dateTime('lastMessage')->nullable();
            $table->json('metadataFriendship')->nullable();
            $table->json('metadataOwner')->nullable();
            $table->timestamps();

            $table->index('lastMessage');
            $table->index('counterpartId');
            $table->index('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
