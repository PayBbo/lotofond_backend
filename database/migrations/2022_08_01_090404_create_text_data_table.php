<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTextDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('text_data', function (Blueprint $table) {
            $table->id();
            $table->string('header');
            $table->longText('value');
            $table->enum('type', ['info', 'help', 'about', 'contacts', 'buyBlock']);
            $table->enum('screen', ['О приложении', 'Помощь', 'О нас', 'Контакты', 'Блок "Купить"']);
            $table->json('points')->nullable();
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
        Schema::dropIfExists('text_data');
    }
}
