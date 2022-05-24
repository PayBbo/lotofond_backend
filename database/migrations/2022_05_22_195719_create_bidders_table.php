<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBiddersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('bidders', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('inn', 20);
            $table->string('ogrn', 100);
            $table->string('snils', 20);
            $table->string('address', 255);
            $table->string('reg_number', 100);
            $table->string('cpo', 255);
            $table->unsignedBigInteger('region_id')->nullable();
            $table->unsignedBigInteger('bidder_type_id')->nullable();
            $table->unsignedBigInteger('bidder_category_id')->nullable();
            $table->foreign('region_id')->references('id')
                ->on('regions')->nullOnDelete();
            $table->foreign('bidder_type_id')->references('id')
                ->on('bidder_types')->nullOnDelete();
            $table->foreign('bidder_category_id')->references('id')
                ->on('bidder_categories')->nullOnDelete();
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
        Schema::dropIfExists('bidders');
    }
}
