<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBiddersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('bidders', function (Blueprint $table) {
            $table->id();
            /*common fields*/
            $table->longText('name');
            $table->string('bankrupt_id')->nullable();
            $table->string('inn', 12)->unique();
            $table->string('snils', 14)->nullable();
            $table->enum('type', ['person', 'company'])->default('person');
            $table->string('address', 255)->nullable();
            $table->unsignedBigInteger('region_id')->nullable();
            $table->foreign('region_id')->references('id')
                ->on('regions')->nullOnDelete();
            $table->string('correspondence_address', 255)->nullable();
            /*only person*/
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('ogrn', 15)->nullable();
            $table->string('ogrnip', 15)->nullable();
            /*only company*/
            $table->mediumText('short_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            /*only debtor*/
            $table->unsignedBigInteger('debtor_category_id')->nullable();
            $table->foreign('debtor_category_id')->references('id')
                ->on('debtor_categories')->nullOnDelete();
            /*only arbitr manager*/
            $table->string('reg_num', 30)->nullable();
            $table->unsignedBigInteger('sro_au_id')->nullable();
            $table->foreign('sro_au_id')->references('id')
                ->on('sro_aus')->nullOnDelete();
            $table->dateTime('reg_date')->nullable();
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
        Schema::dropIfExists('bidders');
    }
}
