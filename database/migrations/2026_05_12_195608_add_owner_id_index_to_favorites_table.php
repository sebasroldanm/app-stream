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
        Schema::table('customer_owner_favorites', function (Blueprint $table) {
            // Add index on owner_id to speed up "not favorited" queries
            $table->index('owner_id', 'favorites_owner_id_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_owner_favorites', function (Blueprint $table) {
            $table->dropIndex('favorites_owner_id_index');
        });
    }
};
