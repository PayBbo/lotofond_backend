<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();
            $table->string('id_efrsb', 255)->unique()->nullable();
            $table->string('id_external', 255)->unique()->nullable();
            $table->string('guid', 50)->unique()->nullable();
            $table->string('trade_id', 255);
            $table->unsignedBigInteger('debtor_id');
            $table->unsignedBigInteger('arbitr_manager_id')->nullable();
            $table->unsignedBigInteger('company_trade_organizer_id')->nullable();
            $table->unsignedBigInteger('trade_place_id')->nullable();
            $table->unsignedBigInteger('auction_type_id');
            $table->dateTime('publish_date');
            $table->dateTime('event_start_date')->nullable();
            $table->dateTime('event_end_date')->nullable();
            $table->dateTime('application_start_date');
            $table->dateTime('application_end_date');
            $table->dateTime('result_date')->nullable();
            $table->foreign('debtor_id')->references('id')
                ->on('bidders')->cascadeOnDelete();
            $table->foreign('arbitr_manager_id')->references('id')
                ->on('bidders')->cascadeOnDelete();
            $table->foreign('company_trade_organizer_id')->references('id')
                ->on('bidders')->cascadeOnDelete();
            $table->foreign('trade_place_id')->references('id')
                ->on('trade_places')->cascadeOnDelete();
            $table->foreign('auction_type_id')->references('id')
                ->on('auction_types')->cascadeOnDelete();
            $table->enum('price_form', ['open', 'close']);
            $table->string('case_number')->nullable();
            $table->string('court')->nullable();
            $table->dateTime('date_publish_smi')->nullable();
            $table->dateTime('date_publish_efir')->nullable();
            $table->longText('application_rules')->nullable();
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
        Schema::dropIfExists('auctions');
    }
}
