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
        Schema::create('productions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_id');
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
            $table->decimal('currentMoney')->default(1000);
            $table->float('moneyRate')->default(0.0);
            $table->float('algaeMass')->default(0.0);
            $table->float('algaeRate')->default(0.0);
            $table->integer('tanks')->default(1);
            $table->integer('maxTanks')->default(8);
            $table->integer('farms')->default(1);
            $table->float('nutrientPerc')->default(100);
            $table->float('nutrientsRate')->default(0);
            $table->float('co2Amount')->default(100);
            $table->float('co2Rate')->default(0);
            $table->float('temp')->default(25);
            $table->float('farmLight');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productions');
    }
};
