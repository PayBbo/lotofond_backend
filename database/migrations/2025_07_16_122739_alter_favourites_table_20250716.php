<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterFavouritesTable20250716 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('favourites', function (Blueprint $table) {
            $table->boolean('main')->after('color')->index()->default(false)->comment('системная папка');
        });

        \Illuminate\Support\Facades\DB::table('favourites')->where('title', 'Общее')->update([
            'main' => true
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('favourites', function (Blueprint $table) {
            $table->dropColumn('main');
        });
    }
}
