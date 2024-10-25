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
        Schema::create('raitings', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('yard_id');
            $table->integer('point');
            $table->text('comment');
            $table->boolean('block');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raitings');
    }
};
