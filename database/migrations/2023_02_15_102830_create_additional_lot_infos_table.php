<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdditionalLotInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('additional_lot_infos', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->nullable();
            $table->longText('message');
            $table->boolean('is_moderated')->default(false);
            $table->unsignedBigInteger('lot_id');
            $table->foreign('lot_id')->references('id')
                ->on('lots')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::table('lot_files', function (Blueprint $table) {
            $table->unsignedBigInteger('additional_lot_info_id')->nullable();
            $table->foreign('additional_lot_info_id')->references('id')
                ->on('additional_lot_infos')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('additional_lot_infos');
    }
}
