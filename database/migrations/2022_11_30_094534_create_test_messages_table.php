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
         *     'lot_id',
        'message_id',
        'start_price',
        'auction_step',
        'auction_step_unit',
        'price_reduction',
        'text',
        'description',
        'change_desc',
        'period',
        'min_price',
        'price_red_json'*/
        Schema::create('test_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lot_id');
            $table->foreign('lot_id')->references('id')
                ->on('lots')->cascadeOnDelete();
            $table->string('message_id');
            $table->double('start_price');
            $table->double('min_price')->nullable();
            $table->double('auction_step')->nullable();
            $table->string('auction_step_unit')->nullable();
            $table->longText('price_reduction')->nullable();
            $table->longText('description')->nullable();
            $table->longText('change_desc')->nullable();
            $table->longText('text')->nullable();
            $table->json('price_red_json')->nullable();
            $table->integer('period')->nullable();
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
