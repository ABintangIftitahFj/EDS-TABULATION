<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('round_id')->constrained()->onDelete('cascade');
            $table->foreignId('room_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('adjudicator_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('gov_team_id')->nullable()->constrained('teams')->onDelete('cascade');
            $table->foreignId('opp_team_id')->nullable()->constrained('teams')->onDelete('cascade');
            $table->foreignId('winner_id')->nullable()->constrained('teams')->onDelete('set null');
            $table->text('panel_judges')->nullable();
            $table->enum('status', ['scheduled', 'completed', 'in_progress'])->default('scheduled');
            $table->boolean('is_completed')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
