<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('adjudicators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->string('institution')->nullable();
            $table->boolean('is_available')->default(true);
            $table->boolean('is_present')->default(false); // For check-in
            $table->enum('level', ['trainee', 'panelist', 'chair', 'deputy_chair'])->default('panelist');
            $table->float('rating')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('adjudicators');
    }
};
