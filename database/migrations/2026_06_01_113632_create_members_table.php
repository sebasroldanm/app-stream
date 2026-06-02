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
        Schema::create('members', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();

            // Ranking
            $table->string('ranking_league');
            $table->integer('ranking_level');
            $table->boolean('ranking_isEx');

            // Status
            $table->boolean('isDeleted');
            $table->string('username');
            $table->boolean('isOnline');
            $table->boolean('isBlocked');
            $table->boolean('isRegular');
            $table->boolean('isExGreen');
            $table->boolean('isUltimate');
            $table->boolean('isGreen');
            $table->boolean('hasVrDevice');
            $table->boolean('isModel');
            $table->boolean('isStudio');
            $table->boolean('isAdmin');
            $table->boolean('isSupport');
            $table->boolean('hasAdminBadge');
            $table->boolean('isPermanentlyBlocked');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
