<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArbitrManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('arbitr_managers', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('arbitr_manager_id')->nullable();
            $table->string('name', 255);
            $table->string('inn', 12);
            $table->string('reg_num', 30)->nullable();
            $table->string('sro_reg_num', 30)->nullable();
            $table->string('ogrnip', 15)->nullable();
            $table->unsignedBigInteger('region_id')->nullable();
            $table->foreign('region_id')->references('id')
                ->on('regions')->nullOnDelete();
            $table->unsignedBigInteger('sro_au_id')->nullable();
            $table->foreign('sro_au_id')->references('id')
                ->on('sro_aus')->nullOnDelete();
            $table->dateTime('date_of_last_modifier')->nullable();
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
        Schema::dropIfExists('arbitr_managers');
    }
}
