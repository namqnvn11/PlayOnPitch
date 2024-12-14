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
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('reservation_time_slot');
            $table->dropColumn('yard_id');
            $table->integer('user_id')->nullable()->change();
            $table->integer('contact_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->string('reservation_time_slot');
            $table->string('yard_id');
            $table->integer('user_id')->change();
            $table->dropColumn('contact_id');
        });
    }
};
