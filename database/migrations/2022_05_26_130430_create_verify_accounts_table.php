<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerifyAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verify_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('value')->nullable();
            $table->string('token');
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('is_delete')->default(false);
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
        Schema::dropIfExists('verify_accounts');
    }
}
