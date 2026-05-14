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
        Schema::table('feeds', function (Blueprint $table) {
            // Index for filtering by owner and ordering by date
            $table->index(['owner_id', 'updatedAt'], 'feeds_owner_id_updatedat_index');
            // Index for stories (filtering by date and type)
            $table->index(['updatedAt', 'type'], 'feeds_updatedat_type_index');
        });

        Schema::table('owners', function (Blueprint $table) {
            // Index for online owners in right sidebar (filtering and ordering)
            $table->index(['isOnline', 'isLive', 'statusChangedAt'], 'owners_online_live_status_index');
            // Index for offline owners in right sidebar
            $table->index(['isOnline', 'statusChangedAt'], 'owners_online_status_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feeds', function (Blueprint $table) {
            $table->dropIndex('feeds_owner_id_updatedat_index');
            $table->dropIndex('feeds_updatedat_type_index');
        });

        Schema::table('owners', function (Blueprint $table) {
            $table->dropIndex('owners_online_live_status_index');
            $table->dropIndex('owners_online_status_index');
        });
    }
};
