<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistryNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('registry_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('message_id');
            $table->string('guid');
            $table->json('files')->nullable();
            $table->unsignedBigInteger('debtor_id');
            $table->unsignedBigInteger('type_id');
            $table->foreign('debtor_id')->references('id')
                ->on('bidders')->cascadeOnDelete();
            $table->foreign('type_id')->references('id')
                ->on('registry_notification_types')->cascadeOnDelete();
            $table->dateTime('publish_date');
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
        Schema::dropIfExists('registry_notifications');
    }
}
