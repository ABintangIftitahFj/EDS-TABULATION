<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('adjudicators', function (Blueprint $table) {
            // Make user_id nullable since adjudicators can be imported without user accounts
            $table->foreignId('user_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('adjudicators', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable(false)->change();
        });
    }
};