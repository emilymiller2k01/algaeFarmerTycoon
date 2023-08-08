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
        Schema::create('powers', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['solar', 'wind', 'gas']);
            $table->decimal('startup_cost', 8, 2)->default(0); // default is 0 since solar and wind might have a startup cost but gas won't
            $table->decimal('ongoing_cost', 8, 2)->default(0); // default is 0 since only gas will have an ongoing cost
            $table->float('mw');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('powers');
    }
};
