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
        Schema::create('owner_info_types', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // Ej: instagram_url, whatsapp_number, profile_photo
            $table->string('label'); // Ej: 'Instagram', 'WhatsApp', 'Foto de Perfil'
            $table->enum('data_type', ['text', 'number', 'url', 'file', 'json'])->default('text');
            $table->string('category')->nullable(); // Ej: 'social', 'contact', 'media'
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('owner_info_types');
    }
};
