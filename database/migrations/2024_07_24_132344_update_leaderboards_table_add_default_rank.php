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
        Schema::table('leaderboards', function (Blueprint $table) {
            $table->integer('rank')->default(0)->change(); // Set default value for 'rank'
            $table->integer('points')->default(0)->change(); // Set default value for 'points'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leaderboards', function (Blueprint $table) {
            $table->integer('rank')->default(null)->change(); // Remove default value if rolling back
            $table->integer('points')->default(null)->change(); // Remove default value if rolling back
        });
    }
};
