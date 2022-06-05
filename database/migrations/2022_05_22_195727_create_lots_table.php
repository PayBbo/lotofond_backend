<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('lots', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('number');
            $table->json('images')->nullable();
            $table->bigInteger('price');
            $table->bigInteger('auction_step')->nullable();
            $table->boolean('is_step_rub')->default(true);
            $table->boolean('is_deposit_rub')->default(true);
            $table->bigInteger('deposit')->nullable();
            $table->longText('description')->nullable();
            $table->boolean('is_ecp')->nullable();
            $table->json('files')->nullable();
            $table->enum('price_state', ['up', 'low', 'hold'])->default('hold');
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('id')
                ->on('statuses')->cascadeOnDelete();
            $table->unsignedBigInteger('auction_id');
            $table->foreign('auction_id')->references('id')
                ->on('auctions')->cascadeOnDelete();
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
        Schema::dropIfExists('lots');
    }
}
