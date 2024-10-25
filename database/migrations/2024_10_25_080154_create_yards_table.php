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
        Schema::create('yards', function (Blueprint $table) {
            $table->id();
            $table->integer('boss_id');
            $table->string('yard_name');
            $table->string('yard_type');
            $table->text('description');
            $table->boolean('block');
            $table->integer('district_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yards');
    }
};
