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
            $table->bigInteger('number');
            $table->string('cadastral_number')->nullable();
            $table->boolean('is_parse_ecp')->default(false);
            $table->json('images')->nullable();
            $table->decimal('start_price', 15,2);
            $table->decimal('auction_step', 15, 2)->nullable();
            $table->boolean('is_step_rub')->default(true);
            $table->boolean('is_deposit_rub')->default(true);
            $table->decimal('deposit', 15, 2)->nullable();
            $table->longText('description')->nullable();
            $table->enum('price_state', ['up', 'low', 'hold'])->default('hold');
            $table->json('price_reduction')->nullable();
            $table->longText('concours')->nullable();
            $table->longText('participants')->nullable();
            $table->longText('payment_info')->nullable();
            $table->longText('sale_agreement')->nullable();
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('id')
                ->on('statuses')->cascadeOnDelete();
            $table->unsignedBigInteger('auction_id');
            $table->foreign('auction_id')->references('id')
                ->on('auctions')->cascadeOnDelete();
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
