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
        Schema::table('rounds', function (Blueprint $table) {
            $table->boolean('is_draw_published')->default(false)->after('is_published');
            $table->timestamp('draw_published_at')->nullable()->after('is_draw_published');
            $table->timestamp('motion_published_at')->nullable()->after('is_motion_published');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rounds', function (Blueprint $table) {
            $table->dropColumn(['is_draw_published', 'draw_published_at', 'motion_published_at']);
        });
    }
};
