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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fk_owners_id')
                ->nullable()
                ->constrained('owners')
                ->onDelete('cascade');
            $table->foreignId('fk_customer_id')
                ->constrained('customers')
                ->onDelete('cascade');
            $table->foreignId('fk_telegram_messages_id')
                ->nullable()
                ->constrained('telegram_messages')
                ->onDelete('set null');
            $table->text('body')->nullable();
            $table->string('status')->default('published');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
