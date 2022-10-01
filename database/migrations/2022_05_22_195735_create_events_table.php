<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('time');
            $table->string('title', 255);
            $table->enum('event_type', ['task', 'event', 'reminder']);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')
                ->on('users')->cascadeOnDelete();
            $table->unsignedBigInteger('favourite_lot_id')->nullable();
            $table->foreign('favourite_lot_id')->references('id')
                ->on('favourite_lot')->cascadeOnDelete();
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
        Schema::dropIfExists('events');
    }
}
