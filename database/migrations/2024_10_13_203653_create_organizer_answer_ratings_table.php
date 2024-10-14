<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizerAnswerRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizer_answer_ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index()->comment('id пользователя');
            $table->foreign('user_id')->references('id')
                ->on('users')->cascadeOnDelete();
            $table->unsignedBigInteger('answer_id')->index()->comment('id ответа организатора');
            $table->foreign('answer_id')->references('id')
                ->on('additional_lot_infos')->cascadeOnDelete();
            $table->string('comment')->nullable()->comment('комментарий');
            $table->integer('estimate')->index()->default(0)->comment('оценка');
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
        Schema::dropIfExists('organizer_answer_ratings');
    }
}
