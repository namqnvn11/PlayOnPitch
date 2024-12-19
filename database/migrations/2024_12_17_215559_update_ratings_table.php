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
        Schema::table('ratings', function (Blueprint $table) {
            $table->dropColumn('yard_id');
            $table->integer('boss_id');
            $table->integer('report_count')->default(0);
            $table->enum('status',['pending','approved','blocked'])->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->integer('yard_id');
            $table->dropColumn('boss_id');
            $table->dropColumn('report_count');
            $table->dropColumn('status');
        });
    }
};
