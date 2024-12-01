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
        Schema::table('images', function (Blueprint $table) {
            $table->longText('img')->change();
            $table->integer('user_id')->default(0)->change();
            $table->integer('boss_id')->default(0)->change();
            $table->integer('yard_id')->default(0)->change();
            $table->integer('voucher_id')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('images', function (Blueprint $table) {
            $table->string('img')->change();
            $table->integer('user_id')->change();
            $table->integer('boss_id')->change();
            $table->integer('yard_id')->change();
            $table->integer('voucher_id')->change();
        });
    }
};
