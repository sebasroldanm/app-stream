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
            $table->string('bodyType')->nullable();
            $table->string('eyeColor')->nullable();
            $table->integer('age')->nullable();
            $table->date('birthDate')->nullable();
            $table->integer('favoritedCount')->default(0);
            $table->datetime('offlineStatusUpdatedAt')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('owners', function (Blueprint $table) {
            $table->dropColumn('bodyType');
            $table->dropColumn('eyeColor');
            $table->dropColumn('age');
            $table->dropColumn('birthDate');
            $table->dropColumn('favoritedCount');
            $table->dropColumn('offlineStatusUpdatedAt');
        });
    }
};
