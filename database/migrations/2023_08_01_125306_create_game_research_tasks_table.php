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
        Schema::create('game_research_tasks', function (Blueprint $table) {
            $table->foreignId('game_id')->references('id')->on('games');
            $table->foreignId('research_tasks_id')->references('id')->on('research_tasks');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_research_tasks');
    }
};
