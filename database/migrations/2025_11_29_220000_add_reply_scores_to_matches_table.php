<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('matches', function (Blueprint $table) {
            $table->decimal('gov_reply_score', 4, 1)->nullable()->after('gov_rank');
            $table->decimal('opp_reply_score', 4, 1)->nullable()->after('opp_rank');
        });
    }

    public function down()
    {
        Schema::table('matches', function (Blueprint $table) {
            $table->dropColumn(['gov_reply_score', 'opp_reply_score']);
        });
    }
};
