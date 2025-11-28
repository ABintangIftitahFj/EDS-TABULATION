<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('competition_histories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tournament name
            $table->string('result'); // e.g., Champion, Runner-up, Semifinalist
            $table->year('year');
            $table->json('team_members')->nullable(); // Array of participant names
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competition_histories');
    }
};
