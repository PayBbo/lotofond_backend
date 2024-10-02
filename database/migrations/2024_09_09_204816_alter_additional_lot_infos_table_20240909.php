<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAdditionalLotInfosTable20240909 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('additional_lot_infos', function (Blueprint $table) {
            $table->longText('initial_message')->nullable()->after('message')->comment('оригинальное сообщение');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('additional_lot_infos', function (Blueprint $table) {
            $table->dropColumn('initial_message');
        });
    }
}
