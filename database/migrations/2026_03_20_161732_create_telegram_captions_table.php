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
        Schema::create('telegram_captions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fk_telegram_messages_id')->constrained('telegram_messages')->onDelete('cascade');
            $table->text('caption');
            $table->enum('type', ['text', 'hashtag', 'url', 'mention', 'bot_command'])->default('text');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telegram_captions');
    }
};
