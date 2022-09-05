<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLotMonitoringTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('lot_monitoring', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('monitoring_id');
            $table->unsignedBigInteger('lot_id');
            $table->foreign('lot_id')->references('id')
                ->on('lots')->cascadeOnDelete();
            $table->foreign('monitoring_id')->references('id')
                ->on('monitorings')->cascadeOnDelete();
            $table->boolean('has_notification')->default(false);
            $table->dateTime('created_at');
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
        Schema::dropIfExists('lot_monitoring');
    }
}
