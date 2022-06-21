<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBiddingParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bidding_participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bidding_result_id');
            $table->unsignedBigInteger('bidder_id');
            $table->foreign('bidding_result_id')->references('id')
                ->on('bidding_results')->cascadeOnDelete();
            $table->foreign('bidder_id')->references('id')
                ->on('bidders')->cascadeOnDelete();
            $table->boolean('is_winner')->default(false);
            $table->boolean('is_buyer')->default(false);
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
        Schema::dropIfExists('bidding_participants');
    }
}
