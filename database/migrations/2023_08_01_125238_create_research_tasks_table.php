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
        Schema::create('research_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('task');
            $table->boolean('automation');
            $table->boolean('completed')->default(false);
            $table->float('mw');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('research_tasks');
    }
};
