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
        Schema::create('owner_custom_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained()->onDelete('cascade');
            $table->foreignId('info_type_id')->constrained('owner_info_types')->onDelete('cascade');
            $table->foreignId('source_id')->nullable()->constrained('owner_info_sources')->onDelete('set null');
            $table->json('data_info')->nullable(); // Puede contener texto, URL, o metadata de archivo
            $table->timestamps();

            $table->index(['owner_id', 'info_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('owner_custom_infos');
    }
};
