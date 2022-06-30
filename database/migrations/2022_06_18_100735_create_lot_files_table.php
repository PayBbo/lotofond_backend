<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLotFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lot_files', function (Blueprint $table) {
            $table->id();
            $table->mediumText('url');
            $table->enum('type', ['file', 'image'])->default('file');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('lot_id');
            $table->foreign('lot_id')->references('id')
                ->on('lots')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')
                ->on('users')->cascadeOnDelete();
            $table->unsignedBigInteger('trade_message_id')->nullable();
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
        Schema::dropIfExists('lot_files');
    }
}
