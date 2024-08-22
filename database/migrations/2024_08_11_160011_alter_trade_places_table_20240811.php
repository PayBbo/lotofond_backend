<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTradePlacesTable20240811 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trade_places', function (Blueprint $table) {
            $table->string('code')->nullable()->index('code')->after('site')->comment('код');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trade_places', function (Blueprint $table) {
            $table->dropIndex('code');
            $table->dropColumn('code');
        });
    }
}
