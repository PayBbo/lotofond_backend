<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriceReductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_reductions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lot_id');
            $table->foreign('lot_id')->references('id')
                ->on('lots')->cascadeOnDelete();
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->decimal('price', 15,2)->default(0.00);
            $table->decimal('deposit', 15,2)->default(0.00);
            $table->integer('percent')->default(0);
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
        Schema::dropIfExists('price_reductions');
    }
}
