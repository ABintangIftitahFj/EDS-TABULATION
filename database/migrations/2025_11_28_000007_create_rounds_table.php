<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rounds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->enum('type', ['preliminary', 'elimination'])->default('preliminary');
            $table->text('motion')->nullable();
            $table->text('info_slide')->nullable();
            $table->boolean('is_published')->default(false);
            $table->boolean('is_motion_published')->default(false);
            $table->enum('status', ['draft', 'generated', 'released', 'in_progress', 'completed'])->default('draft');
            $table->timestamp('start_time')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rounds');
    }
};
