<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('lot_id')->nullable();
            $table->string('email', 255)->nullable();
            $table->string('username', 255)->nullable();
            $table->string('phone', 255)->nullable();
            $table->string('for_answer')->nullable();
            $table->string('topic')->nullable();
            $table->string('question')->nullable();
            $table->json('files')->nullable();
            $table->string('cadastral_number')->nullable();
            $table->unsignedBigInteger('tariff_id');
            $table->foreign('tariff_id')->references('id')
                ->on('tariffs')->cascadeOnDelete();
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->foreign('payment_id')->references('id')
                ->on('payments')->cascadeOnDelete();
            $table->timestamp('answer_date')->nullable();
            $table->foreign('user_id')->references('id')
                ->on('users')->cascadeOnDelete();
            $table->foreign('lot_id')->references('id')
                ->on('lots')->cascadeOnDelete();
            $table->enum('status', ['notProcessed', 'inProgress', 'rejectedBySystem', 'rejectedByUser', 'completed'])->default('notProcessed');
            $table->enum('format', ['pdf', 'html', 'zip'])->default('pdf');
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
        Schema::dropIfExists('applications');
    }
}
