<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('lots', function (Blueprint $table) {
            $table->id();
            $table->integer('number')->unique();
            $table->string('address', 255);
            $table->json('images')->nullable();
            $table->bigInteger('price');
            $table->bigInteger('auction_step');
            $table->bigInteger('deposit');
            $table->longText('description');
            $table->boolean('is_ecp')->nullable();
            $table->string('title', 255);
            $table->json('files')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('status_id');
            $table->foreign('category_id')->references('id')
                ->on('categories')->cascadeOnDelete();
            $table->foreign('status_id')->references('id')
                ->on('statuses')->cascadeOnDelete();
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
        Schema::dropIfExists('lots');
    }
}
