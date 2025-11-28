<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ballots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('match_id')->constrained()->onDelete('cascade');
            $table->foreignId('adjudicator_id')->constrained()->onDelete('cascade');
            $table->foreignId('speaker_id')->constrained()->onDelete('cascade');
            $table->integer('score');
            $table->enum('team_role', ['gov', 'opp']);
            $table->string('position');
            $table->boolean('is_reply')->default(false);
            $table->text('feedback')->nullable();
            $table->boolean('is_consensus')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ballots');
    }
};
