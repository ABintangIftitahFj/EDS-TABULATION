<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('matches', function (Blueprint $table) {
            $table->foreignId('cg_team_id')->nullable()->constrained('teams')->onDelete('cascade');
            $table->foreignId('co_team_id')->nullable()->constrained('teams')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('matches', function (Blueprint $table) {
            $table->dropForeign(['cg_team_id']);
            $table->dropForeign(['co_team_id']);
            $table->dropColumn(['cg_team_id', 'co_team_id']);
        });
    }
};
