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
        Schema::table('rounds', function (Blueprint $table) {
            if (!Schema::hasColumn('rounds', 'is_locked')) {
                $table->boolean('is_locked')->default(false)->after('results_published');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rounds', function (Blueprint $table) {
            if (Schema::hasColumn('rounds', 'is_locked')) {
                $table->dropColumn('is_locked');
            }
        });
    }
};
