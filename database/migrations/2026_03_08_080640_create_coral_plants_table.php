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
        Schema::create('coral_plants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['coral', 'plant']);
            $table->longText('description')->nullable();
            $table->string('light_requirement');
            $table->string('water_flow');
            $table->string('compatibility')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coral_plants');
    }
};
