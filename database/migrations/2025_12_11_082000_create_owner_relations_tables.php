<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('owner_relation_groups', function (Blueprint $table) {
            $table->id();
            $table->boolean('verified')->default(false);
            $table->text('description')->nullable();
            $table->json('attributes')->nullable();
            $table->timestamps();
        });

        Schema::create('owner_relations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('owners')->onDelete('cascade');
            $table->foreignId('owner_relation_group_id')->constrained('owner_relation_groups')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('owner_relations');
        Schema::dropIfExists('owner_relation_groups');
    }
};
