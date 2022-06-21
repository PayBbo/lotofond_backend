<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBiddingResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bidding_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trade_message_id');
            $table->foreign('trade_message_id')->references('id')
                ->on('trade_messages')->cascadeOnDelete();
            $table->bigInteger('end_price')->nullable();
            $table->longText('substantiation')->nullable();
            $table->string('contract_number')->nullable();
            $table->dateTime('contract_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bidding_results');
    }
}
