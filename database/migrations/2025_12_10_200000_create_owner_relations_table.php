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
        Schema::create('owner_relations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('owners')->onDelete('cascade');
            $table->foreignId('related_owner_id')->constrained('owners')->onDelete('cascade');
            $table->boolean('verified')->default(false);
            $table->text('description')->nullable();
            $table->json('attributes')->nullable();
            $table->timestamps();

            $table->unique(['owner_id', 'related_owner_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('owner_relations');
    }
};
?>
