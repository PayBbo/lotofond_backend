<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRegionsTable20250318 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('regions', function (Blueprint $table) {
            $table->boolean('is_center')->default(false)->comment('административный центр');
        });
        \Illuminate\Support\Facades\DB::table('regions')->insert([
                [
                    "title" => "г. Майкоп",
                    "code" => "Maykop",
                    "numbers" => "01", "is_center" => true, "region_group_id" => '8'
                ],
                [
                    "title" => "г. Уфа",
                    "code" => "Ufa",
                    "numbers" => "02", "is_center" => true, "region_group_id" => '2'
                ],
                [
                    "title" => "г. Улан-Удэ",
                    "code" => "UlanUde",
                    "numbers" => "03", "is_center" => true, "region_group_id" => '5'
                ],
                [
                    "title" => "г. Горно-Алтайск",
                    "code" => "GornoAltaisk",
                    "numbers" => "04", "is_center" => true, "region_group_id" => '5'
                ],
                [
                    "title" => "г. Петропавловск-Камчатский",
                    "code" => "PetropavlovskKamchatsky",
                    "numbers" => "41", "is_center" => true, "region_group_id" => '1'
                ],
                [
                    "title" => "г. Петрозаводск",
                    "code" => "Petrozavodsk",
                    "numbers" => "10", "is_center" => true, "region_group_id" => '3'
                ],
                [
                    "title" => "г. Сыктывкар",
                    "code" => "Syktyvkar",
                    "numbers" => "11", "is_center" => true, "region_group_id" => '3'
                ],
                [
                    "title" => "г. Кострома",
                    "code" => "Kostroma",
                    "numbers" => "34", "is_center" => true, "region_group_id" => '7'
                ],
                [
                    "title" => "г. Калуга",
                    "code" => "Kaluga",
                    "numbers" => "40", "is_center" => true, "region_group_id" => '7'
                ],
                [
                    "title" => "г. Кемерово",
                    "code" => "Kemerovo",
                    "numbers" => "42", "is_center" => true, "region_group_id" => '5'
                ],
                [
                    "title" => "г. Киров",
                    "code" => "Kirov",
                    "numbers" => "43", "is_center" => true, "region_group_id" => '2'
                ],
                [
                    "title" => "г. Курск",
                    "code" => "Kursk",
                    "numbers" => "46", "is_center" => true, "region_group_id" => '7'
                ],
                [
                    // "region" => "Липецкая область",
                    "title" => "г. Липецк",
                    "code" => "Lipetsk",
                    "numbers" => "48", "is_center" => true, "region_group_id" => '7'
                ],
                [
                    // "region" => "Магаданская область",
                    "title" => "г. Магадан",
                    "code" => "Magadan",
                    "numbers" => "49", "is_center" => true, "region_group_id" => '1'
                ],
                [
                    "title" => "г. Мурманск",
                    "code" => "Murmansk",
                    "numbers" => "51", "is_center" => true, "region_group_id" => '3'
                ],
                [
                    "title" => "г. Нижний Новгород",
                    "code" => "NizhnyNovgorod",
                    "numbers" => "52", "is_center" => true, "region_group_id" => '2'
                ],
                [
                    "title" => "г. Великий Новгород",
                    "code" => "VelikyNovgorod",
                    "numbers" => "53", "is_center" => true, "region_group_id" => '3'
                ],
                [
                    "title" => "г. Новосибирск",
                    "code" => "Novosibirsk",
                    "numbers" => "54", "is_center" => true, "region_group_id" => '5'
                ],
                [
                    "title" => "г. Омск",
                    "code" => "Omsk",
                    "numbers" => "55", "is_center" => true, "region_group_id" => '5'
                ],
                [
                    "title" => "г. Оренбург",
                    "code" => "Orenburg",
                    "numbers" => "56", "is_center" => true, "region_group_id" => '2'
                ],
                [
                    "title" => "г. Орёл",
                    "code" => "Orel",
                    "numbers" => "57", "is_center" => true, "region_group_id" => '7'
                ],
                [
                    "title" => "г. Пенза",
                    "code" => "Penza",
                    "numbers" => "58", "is_center" => true, "region_group_id" => '2'
                ],
                [
                    "title" => "г. Пермь",
                    "code" => "Perm",
                    "numbers" => "59", "is_center" => true, "region_group_id" => '2'
                ],
                [
                    "title" => "г. Владивосток",
                    "code" => "Vladivostok",
                    "numbers" => "25", "is_center" => true, "region_group_id" => '1'
                ],
                [
                    "title" => "г. Псков",
                    "code" => "Pskov",
                    "numbers" => "60", "is_center" => true, "region_group_id" => '3'
                ],
                [
                    "title" => "г. Ростов-на-Дону",
                    "code" => "Rostov",
                    "numbers" => "61", "is_center" => true, "region_group_id" => '8'
                ],
                [
                    "title" => "г. Рязань",
                    "code" => "Ryazan",
                    "numbers" => "62", "is_center" => true, "region_group_id" => '7'
                ],
                [
                    "title" => "г. Самара",
                    "code" => "Samara",
                    "numbers" => "63", "is_center" => true, "region_group_id" => '2'
                ],
                [
                    "title" => "г. Саратов",
                    "code" => "Saratov",
                    "numbers" => "64", "is_center" => true, "region_group_id" => '2'
                ],
                [
                    "title" => "г. Южно-Сахалинск",
                    "code" => "YuzhnoSakhalinsk",
                    "numbers" => "65", "is_center" => true, "region_group_id" => '1'
                ],
                [
                    "title" => "г. Екатеринбург",
                    "code" => "Yekaterinburg",
                    "numbers" => "66", "is_center" => true, "region_group_id" => '6'
                ],
                [
                    "title" => "г. Смоленск",
                    "code" => "Smolensk",
                    "numbers" => "67", "is_center" => true, "region_group_id" => '7'
                ],
                [
                    "title" => "г. Ставрополь",
                    "code" => "Stavropol",
                    "numbers" => "26", "is_center" => true, "region_group_id" => '4'
                ],
                [
                    "title" => "г. Тамбов",
                    "code" => "Tambov",
                    "numbers" => "68", "is_center" => true, "region_group_id" => '7'
                ],
                [
                    "title" => "г. Тверь",
                    "code" => "Tver",
                    "numbers" => "69", "is_center" => true, "region_group_id" => '7'
                ],
                [
                    "title" => "г. Томск",
                    "code" => "Tomsk",
                    "numbers" => "70", "is_center" => true, "region_group_id" => '5'
                ],
                [
                    "title" => "г. Тула",
                    "code" => "Tula",
                    "numbers" => "71", "is_center" => true, "region_group_id" => '7'
                ],
                [
                    "title" => "г. Тюмень",
                    "code" => "Tyumen",
                    "numbers" => "72", "is_center" => true, "region_group_id" => '6'
                ],
                [
                    "title" => "г. Ульяновск",
                    "code" => "Ulyanovsk",
                    "numbers" => "73", "is_center" => true, "region_group_id" => '2'
                ],
                [
                    "title" => "г. Хабаровск",
                    "code" => "Khabarovsk",
                    "numbers" => "27", "is_center" => true, "region_group_id" => '1'
                ],
                [
                    "title" => "г. Абакан",
                    "code" => "Abakan",
                    "numbers" => "19", "is_center" => true, "region_group_id" => '5'
                ],
                [
                    "title" => "г. Челябинск",
                    "code" => "Chelyabinsk",
                    "numbers" => "74", "is_center" => true, "region_group_id" => '6'
                ],
                [
                    "title" => "г. Грозный",
                    "code" => "Grozny",
                    "numbers" => "95", "is_center" => true, "region_group_id" => '4'
                ],
                [
                    "title" => "г. Анадырь",
                    "code" => "Anadyr",
                    "numbers" => "87", "is_center" => true, "region_group_id" => '1'
                ],
                [
                    "title" => "г. Ярославль",
                    "code" => "Yaroslavl",
                    "numbers" => "76", "is_center" => true, "region_group_id" => '7'
                ],
                [
                    "title" => "г. Симферополь",
                    "code" => "Simferopole",
                    "numbers" => "91", "is_center" => true, "region_group_id" => '8'
                ],
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('regions', function (Blueprint $table) {
            $table->dropColumn('is_center');
        });
    }
}
