<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();
            $table->integer('number')->unique();
            $table->timestamp('publish_date');
            $table->unsignedBigInteger('debitor_id');
            $table->unsignedBigInteger('arbitration_manager_id')->nullable();
            $table->unsignedBigInteger('organizer_id')->nullable();
            $table->unsignedBigInteger('trading_platform_id')->nullable();
            $table->unsignedBigInteger('auction_type_id');
            $table->json('event_period')->nullable();
            $table->json('application_period')->nullable();
            $table->timestamp('result_date')->nullable();
            $table->foreign('debitor_id')->references('id')
                ->on('bidders')->cascadeOnDelete();
            $table->foreign('arbitration_manager_id')->references('id')
                ->on('bidders')->nullOnDelete();
            $table->foreign('organizer_id')->references('id')
                ->on('bidders')->nullOnDelete();
            $table->foreign('trading_platform_id')->references('id')
                ->on('bidders')->nullOnDelete();
            $table->foreign('auction_type_id')->references('id')
                ->on('auction_types')->cascadeOnDelete();
            $table->timestamps();
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
        Schema::dropIfExists('auctions');
    }
}
