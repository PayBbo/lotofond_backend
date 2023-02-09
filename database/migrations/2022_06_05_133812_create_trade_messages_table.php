<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTradeMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('trade_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lot_id');
            $table->string('number', 255);
            $table->string('guid', 255)->nullable();
            $table->longText('value');
            $table->longText('text')->nullable();
            $table->foreign('lot_id')->references('id')
                ->on('lots')->cascadeOnDelete();
            $table->dateTime('date')->nullable();
            $table->string('param')->nullable();
            $table->string('param_type')->nullable();
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
        Schema::dropIfExists('trade_messages');
    }
}
