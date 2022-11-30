<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
         *       'lot_id',
        'message_id',
        'start_price',
        'auction_step',
        'auction_step_unit',
        'advance',
        'advance_step_unit',
        'price_reduction',
        'organizer',
        'arbitration_manager',
        'sro_au'*/
        Schema::create('test_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lot_id');
            $table->foreign('lot_id')->references('id')
                ->on('lots')->cascadeOnDelete();
            $table->string('message_id');
            $table->double('start_price');
            $table->double('auction_step')->nullable();
            $table->string('auction_step_unit')->nullable();
            $table->double('advance')->nullable();
            $table->string('advance_step_unit')->nullable();
            $table->longText('price_reduction')->nullable();
            $table->json('organizer')->nullable();
            $table->string('organizer_fio')->nullable();
            $table->string('arbitr_fio')->nullable();
            $table->string('organizer_name')->nullable();
            $table->string('arbitr_name')->nullable();
            $table->string('sro')->nullable();
            $table->longText('text')->nullable();
            $table->json('arbitration_manager')->nullable();
            $table->string('trade_site')->nullable();
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
        Schema::dropIfExists('test_messages');
    }
}
