<?php

namespace App\Http\Services\Parse;

use App\Models\Lot;
use App\Models\LotParam;
use App\Models\Param;
use App\Models\PriceReduction;

class DescriptionExtractsService
{
    protected $regexs = [
        '([АВЕКМНОРСТУХавекмнорстухABEKMHOPCTYXaeopcyx][ ]?\d{3}(?<!000)[ ]?[АВЕКМНОРСТУХавекмнорстухABEKMHOPCTYXaeopcyx]{2})', //Обычные
        '(?:(?:([АВЕКМНОРСТУХавекмнорстухABEKMHOPCTYXaeopcyx]{2}[ ]?\d{4}(?<!0000)))|(?:(\d{4}[ ]?(?<!0000)[АВЕКМНОРСТУХавекмнорстухABEKMHOPCTYXaeopcyx]{2})))', //Прицеп/мотоциклы/внедорожные мототранспортные средства
        '([АВЕКМНОРСТУХавекмнорстухABEKMHOPCTYXaeopcyx]{2}[ ]?\d{2}(?<!00)[ ]?[АВЕКМНОРСТУХавекмнорстухABEKMHOPCTYXaeopcyx]{2})', //Мопеды
        '([АВЕКМНОРСТУХавекмнорстухABEKMHOPCTYXaeopcyx]{2}[ ]?\d{3}(?<!000))', //Такси
        '(\d{4}[ ]?(?<!0000)[АВЕКМНОРСТУХавекмнорстухABEKMHOPCTYXaeopcyx]{2})', //Военные
        '(([TtТт])([АВЕКМНОРСТУХавекмнорстухABEKMHOPCTYXaeopcyx]{2}[ ]?\d{3}(?<!000)))', //Окончательно выезжающие за пределы РФ
        '(?:(?:(?:([АВЕКМНОРСТУХавекмнорстухABEKMHOPCTYXaeopcyx][ ]?\d{4}(?<!0000)))|(?:((?:(?:\d{3}(?<!000))|(?:\d{4}(?<!0000)))[ ]?(?:[АВЕКМНОРСТУавекмнорстуABEKMHOPCTYaeopcy]|(?<maybe_size>[ХхXx]))))))', //МВД
        '(([KkКк])([АВЕКМНОРСТУХавекмнорстухABEKMHOPCTYXaeopcyx]{2}[ ]?\d{3}(?<!000)))', //Ретро
        '(([CcСс])([АВЕКМНОРСТУХавекмнорстухABEKMHOPCTYXaeopcyx]{2}[ ]?\d{3}(?<!000)))',//Спорт
        '(?:(?:((\d{3})(?<!000)[ ]?((?:[cCсС]{2})|(?:[cCсС][dD]))[ ]?(\d)))|(?:((\d{3})(?<!000)[ ]?([Dd]|[TtТт])[ ]?(\d{3})))|(?:(([Dd]|[TtТт])[ ]?(\d{3})(?<!000)[ ]?(\d{2}))))' //Дипломаты
    ];
    protected $regexStart = '(?:(?:(?:(?:[Рр][Ее][Гг][Ии][Сс][Тт][Рр][Аа][Цц][Ии][Оо][Нн][Нн][Ыы][Йй][ ]?[Зз][Нн][Аа][Кк])|(?:[Гг][\/\\. ]?[ ]?[Нн][.]?)|(?:[Рр][Ее][Гг][.]?[ ]?[Зз][Нн][Аа][Кк][.]?)|(?:[Гг][Оо][Сс][.]?(?:[Уу][Дд][Аа][Рр][Сс][Тт][Вв][Ее][Нн][Нн][Ыы][Йй])?[ ]?[Нн][.]?(?:[Оо][Мм])?[.]?(?:[Ее][Рр])?)|(?:[Гг][.]?[ ]?[Рр][.]?[ ]?[Зз][.]?)|(?:№))[ ]?[:\-–]?[ ]?)|(?:№)|(?<year>(?:19|20)\d\d )|(?<parenthesis>\()|(?<comma>,[ ]?))';
    protected $regexEnd = '(?(parenthesis)(?(maybe_size)(*FAIL))\))(?(comma)(?(maybe_size)(*FAIL))(?:,|\.|\n|\z))(?(year)(?(maybe_size)(*FAIL))(?:,|\.| |\n|\z))';

    public function getDescriptionExtracts($lot, $description)
    {
        $cadastr_number = '/\d{2}:\d{2}:\d{1,7}:\d{1,}/';
        preg_match_all($cadastr_number, $description, $matches);
        if (count($matches[0]) > 0) {
            foreach (array_unique($matches[0]) as $match) {
                if (!$lot->params()->where('value', $match)->exists() && strlen((string)$match) > 0) {
                    $lot->params()->attach(Param::find(4), ['value' => $match, 'parent_id' => null]);
                    $parseDataFromRosreestr = new ParseDataFromRosreestrService($match);
                    $parseDataFromRosreestr->handle();
                }
            }
        }
        $avto_number = '/' . $this->getAvtoNumberRegex() . '/um';
        preg_match_all($avto_number, $description, $matches);
        $mainParam = new LotParam();
        $mainParam->type = 'transport';
        $mainParam->lot_id = $lot->id;
        if (count($matches['licence_plate']) > 0) {
            $mainParam->save();
            foreach (array_unique($matches['licence_plate']) as $match) {
                $res = str_replace('RUS', '', mb_strtoupper(str_replace(' ', '', $match)));
                if (!$lot->params()->where('value', $res)->exists() && strlen((string)$res) > 0) {
                    $lot->params()->attach(Param::find(5), ['value' => $res, 'parent_id' => $mainParam->id]);
                }
            }
        }
        $avto_vin = '/[A-HJ-NPR-Z0-9]{17}/ui';
        preg_match_all($avto_vin, $description, $matches);
        if (count($matches[0]) > 0) {
            $mainParam->save();
            foreach (array_unique($matches[0]) as $match) {
                $lot->params()->attach(Param::find(6), ['value' => $match, 'parent_id' => $mainParam->id]);
            }
        }
    }

    public function getAvtoNumberRegex()
    {
        $result = $this->regexStart . '(?<licence_plate>(?:';
        $regexs = $this->regexs;
        $last_regex = end($regexs);
        foreach ($regexs as $regex) {
            if ($regex !== $last_regex) {
                $result .= '(?:' . $regex . ')|';
            } else {
                $result .= '(?:' . $regex . ')';
            }
        }
        $result .= ')(?:[ ]?(\d{2,3}(?<!(00)|(000)))(?:[ \/\\\\]?(RUS|rus))?))' . $this->regexEnd;
        return $result;
    }



}
