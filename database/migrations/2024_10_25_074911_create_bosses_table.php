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
        Schema::create('bosses', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('password');
            $table->string('full_name');
            $table->string('phone');
            $table->string('company_name');
            $table->string('company_address');
            $table->boolean('status');
            $table->integer('district_id');
            $table->boolean('block')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bosses');
    }
};
