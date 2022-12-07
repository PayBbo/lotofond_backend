<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEgrnStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('egrn_statements', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->string('status')->default('Создан');
            $table->dateTime('last_check_date')->nullable();
            $table->string('file')->nullable();
            $table->unsignedBigInteger('application_id')->nullable();
            $table->foreign('application_id')
                ->references('id')
                ->on('applications')
                ->nullOnDelete();
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
        Schema::dropIfExists('egrn_statements');
    }
}
