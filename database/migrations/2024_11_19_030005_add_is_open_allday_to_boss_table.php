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
            $table->boolean('is_open_all_day')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bosses', function (Blueprint $table) {
            $table->dropColumn('is_open_all_day');
        });
    }
};
