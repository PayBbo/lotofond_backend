<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('lot_id')->nullable();
            $table->unsignedBigInteger('organizer_id')->nullable();
            $table->string('value', 255);
            $table->foreign('user_id')->references('id')
                ->on('users')->cascadeOnDelete();
            $table->foreign('lot_id')->references('id')
                ->on('lots')->nullOnDelete();
            $table->foreign('type_id')->references('id')
                ->on('notification_types')->cascadeOnDelete();
            $table->foreign('organizer_id')->references('id')
                ->on('bidders')->nullOnDelete();
            $table->dateTime('date')->nullable();
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
        Schema::dropIfExists('notifications');
    }
}
