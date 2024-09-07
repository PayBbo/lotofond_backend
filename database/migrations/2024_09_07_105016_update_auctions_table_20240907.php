<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAuctionsTable20240907 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::table('auctions')
            ->where('source_id', null)->orWhere('source_id', 0)
            ->update([
                'source_id' => 1
            ]);
    }
}
