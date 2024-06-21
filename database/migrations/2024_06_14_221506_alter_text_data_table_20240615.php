<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTextDataTable20240615 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('text_data', function (Blueprint $table) {
            $table->boolean('active')->default(true)->after('points')->comment('активно');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('text_data', function (Blueprint $table) {
            $table->dropColumn('active');
        });
    }
}
