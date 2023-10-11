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
        Schema::create('farm_refineries', function (Blueprint $table) {
            $table->foreignId('farm_id')->references('id')->on('farms')->onDelete('cascade');
            $table->foreignId('refinery_id')->references('id')->on('refineries')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farm_refineries');
    }
};
