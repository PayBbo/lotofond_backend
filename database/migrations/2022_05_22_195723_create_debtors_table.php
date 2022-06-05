<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebtorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('debtors', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('bankrupt_id')->nullable();
            $table->longText('name');
            $table->mediumText('short_name')->nullable();
            $table->string('inn', 12)->nullable();
            $table->string('snils', 11)->nullable();
            $table->string('ogrn', 13)->nullable();
            $table->string('ogrnip', 15)->nullable();
            $table->string('address', 255)->nullable();
            $table->unsignedBigInteger('region_id')->nullable();
            $table->unsignedBigInteger('debtor_category_id')->nullable();
            $table->foreign('region_id')->references('id')
                ->on('regions')->nullOnDelete();
            $table->foreign('debtor_category_id')->references('id')
                ->on('debtor_categories')->nullOnDelete();
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
        Schema::dropIfExists('debtors');
    }
}
