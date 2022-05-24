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
            $table->string('description', 255);
            $table->json('files')->nullable();
            $table->unsignedBigInteger('debitor_id')->nullable();
            $table->unsignedBigInteger('type_id');
            $table->foreign('debitor_id')->references('id')
                ->on('bidders')->cascadeOnDelete();
            $table->foreign('type_id')->references('id')
                ->on('registry_notification_types')->cascadeOnDelete();
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
