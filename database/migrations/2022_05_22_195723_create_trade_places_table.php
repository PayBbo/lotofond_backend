<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTradePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('trade_places', function (Blueprint $table) {
            $table->id();
            $table->longText('name');
            $table->mediumText('owner_name');
            $table->string('inn', 10);
            $table->string('site', 255);
            $table->unsignedBigInteger('trade_place_category_id')->default(1);
            $table->foreign('trade_place_category_id')->references('id')
                ->on('trade_place_categories')->cascadeOnDelete();
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
        Schema::dropIfExists('trade_places');
    }
}
