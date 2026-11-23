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
        Schema::create('water_qualities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aquarium_id')->constrained('aquariums')->onDelete('cascade');  // ← EXPLICITLY specify 'aquariums'
            $table->decimal('ph_level', 3, 2);
            $table->decimal('temperature', 4, 2);
            $table->decimal('ammonia', 5, 3);
            $table->decimal('nitrite', 5, 3);
            $table->decimal('nitrate', 5, 3);
            $table->decimal('salinity', 4, 3)->nullable();
            $table->dateTime('tested_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('water_qualities');
    }
};