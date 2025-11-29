<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('matches', function (Blueprint $table) {
            $table->integer('gov_rank')->nullable();
            $table->integer('opp_rank')->nullable();
            $table->integer('cg_rank')->nullable();
            $table->integer('co_rank')->nullable();
        });
    }

    public function down()
    {
        Schema::table('matches', function (Blueprint $table) {
            $table->dropColumn(['gov_rank', 'opp_rank', 'cg_rank', 'co_rank']);
        });
    }
};
