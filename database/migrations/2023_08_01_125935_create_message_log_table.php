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
        Schema::create('message_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->references('id')->on('games');
            $table->text('message')->nullable(); // Change this to 'text' for storing longer messages
            $table->string('action')->nullable(); // Add an 'action' column
            $table->boolean('cleared')->default(false); // Add a 'cleared' column with a default value of false
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_log');
    }
};
