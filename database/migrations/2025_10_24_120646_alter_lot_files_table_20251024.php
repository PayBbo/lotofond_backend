<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterLotFilesTable20251024 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lot_files', function (Blueprint $table) {
            $table->unsignedBigInteger('auction_id')->after('user_id')
                ->index()->nullable()->comment('id аукциона');
            $table->foreign('auction_id')->references('id')
                ->on('auctions')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lot_files', function (Blueprint $table) {
            $table->dropForeign('auction_id');
            $table->dropColumn('auction_id');
        });
    }
}
