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
        Schema::table('owners', function (Blueprint $table) {
            $table->boolean('isProfileAvailable')->default(true);
            $table->boolean('isBlocked')->default(false);
            $table->boolean('isBanned')->default(false);
            $table->boolean('isGeoBanned')->default(false);
            $table->boolean('isActive')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('owners', function (Blueprint $table) {
            $table->dropColumn('isProfileAvailable');
            $table->dropColumn('isBlocked');
            $table->dropColumn('isBanned');
            $table->dropColumn('isGeoBanned');
            $table->dropColumn('isActive');
        });
    }
};
