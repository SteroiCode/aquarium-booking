<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fish_species', function (Blueprint $table) {
            $table->string('image')->nullable()->after('ph_level');
        });
    }

    public function down(): void
    {
        Schema::table('fish_species', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};
