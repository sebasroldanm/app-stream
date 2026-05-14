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
        Schema::table('photo_album_feeds', function (Blueprint $table) {
            // Add index for album_id to speed up eager loading in timeline
            $table->index('album_id', 'photo_album_feeds_album_id_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('photo_album_feeds', function (Blueprint $table) {
            $table->dropIndex('photo_album_feeds_album_id_index');
        });
    }
};
