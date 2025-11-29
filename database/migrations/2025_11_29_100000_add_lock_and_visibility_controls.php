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
        // Skip is_locked for rounds - already exists
        
        Schema::table('motions', function (Blueprint $table) {
            if (!Schema::hasColumn('motions', 'is_visible')) {
                $table->boolean('is_visible')->default(false)->after('info_slide');
            }
            if (!Schema::hasColumn('motions', 'status')) {
                $table->enum('status', ['draft', 'published', 'locked'])->default('draft')->after('is_visible');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Skip dropping is_locked from rounds - managed by other migration
        
        Schema::table('motions', function (Blueprint $table) {
            if (Schema::hasColumn('motions', 'is_visible')) {
                $table->dropColumn('is_visible');
            }
            if (Schema::hasColumn('motions', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
