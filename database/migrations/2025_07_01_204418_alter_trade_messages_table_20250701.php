<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTradeMessagesTable20250701 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trade_messages', function (Blueprint $table) {
            $table->index('number');
            $table->index('guid');
            $table->index('value');
            $table->index('param_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trade_messages', function (Blueprint $table) {
            $table->dropIndex(['number', 'guid', 'value', 'param_type']);
        });
    }
}
