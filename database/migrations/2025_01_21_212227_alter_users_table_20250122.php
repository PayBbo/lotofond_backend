<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTable20250122 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('tg_id')->index()->nullable()->after('not_settings')->comment('id пользователя в телеграм');
            $table->string('tg_username')->index()->nullable()->after('tg_id')->comment('ник в телеграм');
            $table->timestamp('tg_connected_at')->nullable()->after('tg_username')->comment('дата подключения телеграм');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('tg_id');
            $table->dropColumn('tg_username');
            $table->dropColumn('tg_connected_at');
        });
    }
}
