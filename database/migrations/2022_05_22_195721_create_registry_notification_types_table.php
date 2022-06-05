<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistryNotificationTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('registry_notification_types', function (Blueprint $table) {
            $table->id();
            $table->longText('title')->nullable();
            $table->string('code');
            $table->unsignedBigInteger('notification_type_group_id')->nullable();
            $table->foreign('notification_type_group_id')->references('id')
                ->on('notification_type_groups')->cascadeOnDelete();
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
        Schema::dropIfExists('registry_notification_types');
    }
}
