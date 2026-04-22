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
        Schema::create('telegram_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fk_telegram_chats_id')->constrained('telegram_chats')->onDelete('cascade');
            $table->bigInteger('message_id');
            $table->bigInteger('id_message_parent')->nullable();
            $table->text('text')->nullable();
            $table->timestamp('send_at');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telegram_messages');
    }
};
