<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSroAusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('sro_aus', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('sro_id')->nullable();
            $table->mediumText('name');
            $table->string('reg_num', 30)->nullable();
            $table->string('inn', 10)->nullable();
            $table->string('phone', 50)->nullable();
            $table->dateTime('date_of_last_modifier')->nullable();
            $table->string('ogrn')->nullable();
            $table->string('address')->nullable();
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
        Schema::dropIfExists('sro_aus');
    }
}
