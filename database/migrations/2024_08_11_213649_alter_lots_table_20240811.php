<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterLotsTable20240811 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lots', function (Blueprint $table) {
            $table->string('guid')->nullable()->index('guid')->after('id')->comment('id из источника');
            $table->boolean('active')->nullable()->default(true)->index('active')->after('processed_description')->comment('активность');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lots', function (Blueprint $table) {
            $table->dropIndex('guid');
            $table->dropColumn('guid');
            $table->dropColumn('active');
        });
    }
}
