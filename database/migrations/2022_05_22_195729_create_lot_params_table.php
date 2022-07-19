<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLotParamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('lot_params', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('param_id');
            $table->unsignedBigInteger('lot_id');
            $table->string('value', 255);
            $table->foreign('param_id')->references('id')
                ->on('params')->cascadeOnDelete();
            $table->foreign('lot_id')->references('id')
                ->on('lots')->cascadeOnDelete();
            $table->bigInteger('parent_id')->nullable();
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
        Schema::dropIfExists('lot_params');
    }
}
