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
            $table->string('picture_upload_id', 10)->nullable();
            $table->index('picture_upload_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('photo_album_feeds', function (Blueprint $table) {
            $table->dropIndex(['picture_upload_id']);
            $table->dropColumn('picture_upload_id');
        });
    }
};
