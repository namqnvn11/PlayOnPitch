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
        Schema::create('yard_schedules', function (Blueprint $table) {
            $table->id();
            $table->integer('yard_id');
            $table->date('date');
            $table->float('price_per_hour');
            $table->string('time_slot');
            $table->boolean('status');
            $table->integer('reservation_id');
            $table->boolean('block');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yard_schedules');
    }
};
