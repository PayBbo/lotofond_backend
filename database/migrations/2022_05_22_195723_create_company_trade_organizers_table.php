<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyTradeOrganizersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('company_trade_organizers', function (Blueprint $table) {
            $table->id();
            $table->longText('name');
            $table->mediumText('short_name')->nullable();
            $table->string('inn', 12);
            $table->string('ogrn', 13)->nullable();
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
        Schema::dropIfExists('company_trade_organizers');
    }
}
