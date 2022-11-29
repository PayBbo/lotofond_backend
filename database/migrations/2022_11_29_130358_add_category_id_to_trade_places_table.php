<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryIdToTradePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('trade_places', function (Blueprint $table) {
            $table->unsignedBigInteger('trade_place_category_id')->default(1);
            $table->foreign('trade_place_category_id')->references('id')
                ->on('trade_place_categories')->cascadeOnDelete();
            $table->string('email')->nullable();
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
        Schema::table('trade_places', function (Blueprint $table) {
            //
        });
    }
}
