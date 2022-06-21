<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLotApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lot_applications', function (Blueprint $table) {
            $table->id();
            $table->integer('entry_count');
            $table->integer('accept_count');
            $table->enum('result', ['Accepted', 'Refused'])->nullable();
            $table->longText('cause_of_refuse')->nullable();
            $table->unsignedBigInteger('trade_message_id');
            $table->foreign('trade_message_id')->references('id')
                ->on('trade_messages')->cascadeOnDelete();
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
        Schema::dropIfExists('lot_applications');
    }
}
