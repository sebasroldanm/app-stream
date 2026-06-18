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
        Schema::table('member_stream_stats', function (Blueprint $table) {
            $table->unique(['member_id', 'stream_stat_id'], 'member_stream_stat_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('member_stream_stats', function (Blueprint $table) {
            $table->dropUnique('member_stream_stat_unique');
        });
    }
};
