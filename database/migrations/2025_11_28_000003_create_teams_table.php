<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('institution')->nullable();
            $table->integer('total_vp')->default(0);
            $table->integer('total_speaker_score')->default(0);
            $table->integer('rank')->default(0);
            $table->integer('wins')->default(0);
            $table->integer('losses')->default(0);
            $table->boolean('is_present')->default(false); // For check-in
            $table->enum('status', ['registered', 'confirmed', 'disqualified'])->default('registered');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
