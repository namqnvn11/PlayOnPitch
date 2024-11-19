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
        Schema::table('bosses', function (Blueprint $table) {
            $table->time('time_open')->nullable();
            $table->time('time_close')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bosses', function (Blueprint $table) {
            $table->dropColumn('time_open');
            $table->dropColumn('time_close');
        });
    }
};
