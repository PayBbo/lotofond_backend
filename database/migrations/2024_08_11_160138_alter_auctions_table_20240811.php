<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAuctionsTable20240811 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('auctions', function (Blueprint $table) {
            $table->unsignedBigInteger('debtor_id')->nullable()->after('trade_id')->comment('должник')->change();
            $table->unsignedBigInteger('source_id')->nullable()->index('source_id')->after('price_form')->comment('источник');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('auctions', function (Blueprint $table) {
            $table->dropIndex('source_id');
            $table->dropColumn('source_id');
        });
    }
}
