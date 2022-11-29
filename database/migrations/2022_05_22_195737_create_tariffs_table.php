<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTariffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tariffs', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->text('description')->nullable();
            $table->integer('period')->nullable();
            $table->integer('price')->nullable();
            $table->string('store_id')->nullable();
            $table->integer('admission_price')->nullable();
            $table->json('included_details')->nullable();
            $table->json('excluded_details')->nullable();
            $table->string('code')->nullable();
            $table->string('price_prefix')->nullable();
            $table->enum('type', ['tariff', 'service', 'system'])->default('tariff');
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
        Schema::dropIfExists('tariffs');
    }
}
