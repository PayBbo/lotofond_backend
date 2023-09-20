<?php

namespace App\Http\Services\Parse;

use App\Http\Services\ReestrApiService;
use App\Models\HolidayDate;
use App\Models\Lot;
use App\Models\LotParam;
use App\Models\Param;
use App\Models\PriceReduction;
use App\Models\Region;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Exception;

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
        $changeDesc = $description;
        if (count($matches[0]) > 0) {
            foreach (array_unique($matches[0]) as $match) {
                $changeDesc = str_replace($match, str_repeat('░', strlen($match) - 1), $changeDesc);
                if (!$lot->params()->where('value', $match)->exists() && strlen((string)$match) > 0) {
                    $lot->params()->attach(Param::find(4), ['value' => $match, 'parent_id' => null]);
                    $objectRegion = substr($match, 0, strpos($match, ':'));
                    $region = Region::where('numbers', 'LIKE', '%' . $objectRegion . '%')->first();
                    if ($region) {
                        if (!$lot->objectRegions->contains($region)) {
                            $lot->regions()->attach($region, ['is_debtor_region' => false]);
                        }
                    }
                    /*$reestrApiService = new ReestrApiService();
                    $success = $reestrApiService->searchByCadastralNumber($match);
                    if (!$success) {*/
                        $parseDataFromRosreestr = new ParseDataFromRosreestrService($match);
                        $parseDataFromRosreestr->handle();
                    //}
                }
            }
        }
        $mainParam = new LotParam();
        $mainParam->type = 'transport';
        $mainParam->lot_id = $lot->id;
        $avto_number = '/' . $this->getAvtoNumberRegex() . '/um';
        preg_match_all($avto_number, $description, $matches);
        if (count($matches['licence_plate']) > 0) {
            foreach (array_unique($matches['licence_plate']) as $match) {
                $changeDesc = str_replace($match, str_repeat('░', strlen($match) - 1), $changeDesc);
                $res = str_replace('RUS', '', mb_strtoupper(str_replace(' ', '', $match)));
                if (!$lot->params()->where('value', $res)->exists() && strlen((string)$res) > 0) {
                    if (count(array_unique($matches['licence_plate'])) > 1) {
                        $mainParam = new LotParam();
                        $mainParam->type = 'transport';
                        $mainParam->lot_id = $lot->id;
                        $mainParam->save();
                    } else {
                        $mainParam->save();
                    }
                    $lot->params()->attach(Param::find(5), ['value' => $res, 'parent_id' => $mainParam->id]);
                }
            }
        }
        $avto_vin = '/[A-HJ-NPR-Z0-9]{17}/ui';
        preg_match_all($avto_vin, $description, $matches);
        if (count($matches[0]) > 0) {
            foreach (array_unique($matches[0]) as $match) {
                $changeDesc = str_replace($match, str_repeat('░', strlen($match) - 1), $changeDesc);
                if (!$lot->params()->where('value', $match)->exists() && strlen((string)$match) > 0) {
                    if (count(array_unique($matches[0])) > 1) {
                        $mainParam = new LotParam();
                        $mainParam->type = 'transport';
                        $mainParam->lot_id = $lot->id;
                        $mainParam->save();
                    } else {
                        $mainParam->save();
                    }
                    $lot->params()->attach(Param::find(6), ['value' => $match, 'parent_id' => $mainParam->id]);
                }
            }
        }
        $emailRegex = "/[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})/i";
        preg_match_all($emailRegex, $description, $matches);
        if (count($matches[0]) > 0) {
            foreach (array_unique($matches[0]) as $match) {
                $changeDesc = str_replace($match, str_repeat('░', strlen($match) - 1), $changeDesc);
            }
        }
        $phoneRegex = "/(?:\+|\d)[\d\-\(\) ]{9,}\d/";
        preg_match_all($phoneRegex, $description, $matches);
        if (count($matches[0]) > 0) {
            foreach (array_unique($matches[0]) as $match) {
                $changeDesc = str_replace($match, str_repeat('░', strlen($match) - 1), $changeDesc);
            }
        }
        $lot->processed_description = $changeDesc;
        $lot->save();
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

    public function processDescriptionFromAuction($auctionLots, $fullText, $auction)
    {
        $lotNumbers = [];
        $matchAllParams = [];
        foreach ($auction->lots as $lot) {
            $auctionLot = null;
            preg_match_all(
                '/лот\s*№?\s*(\d+)/iu',
                $lot->description,
                $matchNumber
            );
            $prices = [];
            $similarPercents = [];
            $params = $lot->paramsLot->whereIn('param_id', [4, 5, 6])->pluck('value')->toArray();
            $paramsCount = count($params);
            foreach ($auctionLots as $key => $item) {
                if (count(array_unique($matchNumber[1])) == 1) {
                    $number = $matchNumber[1][0];
                    if ($number == $item['Order']) {
                        $auctionLot = $item;
                        $lotNumbers[] = $lot->number;
                        break;
                    } else {
                        continue;
                    }
                }
                $prices[] = (integer)$item['StartPrice'];
                $similarPrice = false;
                if ($lot->start_price == $item['StartPrice']) {
                    $similarPrice = true;
                }
                if ($paramsCount > 0) {
                    $numberOfMatches = 0;
                    foreach ($params as $param) {
                        if (strpos(mb_strtoupper(str_replace(' ', '', $item['Description'])), $param) !== false) {
                            $numberOfMatches += 1;
                        }
                    }
                    if ($numberOfMatches == $paramsCount) {
                        if ($similarPrice) {
                            $auctionLot = $item;
                            $lotNumbers[] = $lot->number;
                            break;
                        } else {
                            $matchAllParams[] = $key;
                            continue;
                        }
                    }
                }
                $sim = similar_text($lot->description, $item['Description'], $simPercent);
                if ($similarPrice) {
                    $similarPercents[] = $simPercent;
                } else {
                    $similarPercents[] = 0;
                }

            }

            if (!$auctionLot) {
                $counts = array_count_values($prices);
                $start_price = (integer)$lot->start_price;
                $count = array_key_exists($start_price, $counts) ? $counts[$start_price] : 0;
                if ($count == 1 || count($prices) == 1) {
                    $key = array_search($start_price, $prices);
                    $auctionLot = $auctionLots[$key];
                    $lotNumbers[] = $lot->number;
                } else {
                    if (count($matchAllParams) == 1) {
                        $auctionLot = $auctionLots[$matchAllParams[0]];
                        $lotNumbers[] = $lot->number;
                    } elseif (count($similarPercents) > 0) {
                        $maxSimilar = max($similarPercents);
                        $key = array_search($maxSimilar, $similarPercents);
                        $auctionLot = $auctionLots[$key];
                        $lotNumbers[] = $lot->number;
                    }
                }
            }

            if (!$auctionLot) {
                continue;
            }
            $description = $lot->description;
            if (array_key_exists('Description', $auctionLot) && gettype($auctionLot['Description']) != 'array' && strlen((string)$auctionLot['Description']) > 0) {
                if ($paramsCount == 0) {
                    $description = $auctionLot['Description'];
                } else {
                    $numberOfMatches = 0;
                    foreach ($params as $param) {
                        if (strpos(mb_strtoupper(str_replace(' ', '', $auctionLot['Description'])), $param) !== false) {
                            $numberOfMatches += 1;
                        }
                    }
                    if ($numberOfMatches == $paramsCount) {
                        $description = $auctionLot['Description'];
                    } else {
                        $description = null;
                    }
                }
            }
            if (array_key_exists('PriceReduction', $auctionLot) && gettype($auctionLot['PriceReduction']) != 'array' && strlen((string)$auctionLot['PriceReduction']) > 0) {
                $lot->price_reduction = $auctionLot['PriceReduction'];
            }
            if (!is_null($description)) {
                $lot->description = $description;
                $this->getDescriptionExtracts($lot, $description);
            }
            $auctionStep = null;
            $isStepPercent = false;
            if (array_key_exists('Step', $auctionLot) && gettype($auctionLot['Step']) != 'array' && strlen((string)$auctionLot['Step']) > 0) {
                $auctionStep = $auctionLot['Step'];
                $lot->auction_step = $auctionStep;
                if (array_key_exists('AuctionStepUnit', $auctionLot) && gettype($auctionLot['AuctionStepUnit']) != 'array' && strlen((string)$auctionLot['AuctionStepUnit']) > 0) {
                    $isStepPercent = $auctionLot['AuctionStepUnit'] == 'Percent';
                    $lot->is_step_rub = !$isStepPercent;
                }
            }
            if (array_key_exists('Advance', $auctionLot) && gettype($auctionLot['Advance']) != 'array' && strlen((string)$auctionLot['Advance']) > 0) {
                $lot->deposit = $auctionLot['Advance'];
                if (array_key_exists('AdvanceStepUnit', $auctionLot) && gettype($auctionLot['AdvanceStepUnit']) != 'array' && strlen((string)$auctionLot['AdvanceStepUnit']) > 0) {
                    $lot->is_deposit_rub = $auctionLot['AdvanceStepUnit'] != 'Percent';
                }
            }
           /* if (array_key_exists('StartPrice', $auctionLot) && gettype($auctionLot['StartPrice']) != 'array' && strlen((string)$auctionLot['StartPrice']) > 0) {
                $lot->start_price = $auctionLot['StartPrice'];
                if (PriceReduction::where('lot_id', $lot->id)->count() == 0) {
                    PriceReduction::create([
                        'lot_id' => $lot->id,
                        'price' => $auctionLot['StartPrice'],
                        'start_time' => $lot->auction->event_start_date,
                        'end_time' => null,
                        'percent' => 0,
                        'deposit' => 0,
                        'is_system' => true
                    ]);
                }
            }*/
            $lot->save();
            if ($lot->auction->auctionType->title != 'PublicOffer' && $lot->auction->auctionType->title != 'ClosePublicOffer') {
                return $lotNumbers;
            }
            $prices = $lot->showPriceReductions->pluck('price')->toArray();
            if (count($prices) > 0) {
                return $lotNumbers;
            }
            $regexStep = '/(?:(?:(?:снижается)|(?:понижается)|(?:снижения)|(?:уменьшается)|(?:кажды(?:х|е))).*?)(?\'step_number\'\d+)?(?:[ ]?\(?(?\'step_words\'(?:(?:(?:(?<![а-яёА-ЯЁ])(?:(?\'quantitative_0\'н[оу]л)|(?\'quantitative_1\'од)|(?\'quantitative_2\'дв)|(?\'quantitative_3\'тр)|(?\'quantitative_4\'четыр)|(?\'quantitative_5\'пят)|(?\'quantitative_6\'шест)|(?\'quantitative_7\'сем)|(?\'quantitative_8\'вос)|(?\'quantitative_9\'девя)|(?\'quantitative_10\'десят)|(?\'quantitative_40\'соро)|(?\'quantitative_100\'ст))(?=[а-яёА-ЯЁ])(?:((?(quantitative_0)(?:(?:[её]м)|(?:ях)|(?:ями)|(?:ям)|(?:ей)|ь|и|я|ю|е))|(?(quantitative_1)(?:(?:ин)|(?:н(?:(?:ими)|(?:ому)|(?:ого)|(?:ой)|(?:ою)|(?:их)|(?:им)|(?:ом)|о|а|и|у))))|(?(quantitative_2)(?:(?:умя)|(?:ух)|(?:ум)|е|а))|(?(quantitative_3)(?:(?:емя)|(?:[её]х)|(?:[её]м)|и))|(?(quantitative_4)(?:(?:ьмя)|(?:[её]х)|(?:[её]м)|е))|(?(quantitative_5)(?:(?:ью)|ь|и))|(?(quantitative_6)(?:(?:ью)|ь|и))|(?(quantitative_7)(?:(?:ью)|ь|и))|(?(quantitative_8)(?:(?:емь)|(?:[еь]мью)|(?:ьми)))|(?(quantitative_9)(?:(?:тью)|(?:ть)|(?:ти)))|(?(quantitative_10)(?:(?:ью)|ь|и))|(?(quantitative_40)(?:к|(?:ка)))|(?(quantitative_100)(?:о|а)))|(?\'quantitative_second_tens\'(?(quantitative_1)ин(?:надцат(?:(?:ь)|(?:и)|(?:ью))))|(?(quantitative_2)е(?:надцат(?:(?:ь)|(?:и)|(?:ью))))|(?(quantitative_3)и(?:надцат(?:(?:ь)|(?:и)|(?:ью))))|(?(quantitative_4)(?:надцат(?:(?:ь)|(?:и)|(?:ью))))|(?(quantitative_5)(?:надцат(?:(?:ь)|(?:и)|(?:ью))))|(?(quantitative_6)(?:надцат(?:(?:ь)|(?:и)|(?:ью))))|(?(quantitative_7)(?:надцат(?:(?:ь)|(?:и)|(?:ью))))|(?(quantitative_8)ем(?:надцат(?:(?:ь)|(?:и)|(?:ью))))|(?(quantitative_9)т(?:надцат(?:(?:ь)|(?:и)|(?:ью)))))|(?\'quantitative_tens\'(?(quantitative_2)адцат(?:(?:ь)|(?:и)|(?:ью)))|(?(quantitative_3)идцат(?:(?:ь)|(?:и)|(?:ью)))|(?(quantitative_5)(?:(?:ьдесят)|(?:идесяти)|(?:ьюдесятью)))|(?(quantitative_6)(?:(?:ьдесят)|(?:идесяти)|(?:ьюдесятью)))|(?(quantitative_7)(?:(?:ьдесят)|(?:идесяти)|(?:ьюдесятью)))|(?(quantitative_8)(?:(?:емьдесят)|(?:ьмидесяти)|(?:ьмьюдесятью)))|(?(quantitative_9)(?:(?:носто)|(?:носта))))|(?\'quantitative_hundreds\'(?(quantitative_2)(?:(?:ести)|(?:ухсот)|(?:умстам)|(?:умястами)|(?:ухстах)))|(?(quantitative_3)(?:(?:иста)|(?:[её]хсот)|(?:[её]мстам)|(?:емястами)|(?:[её]хстах)))|(?(quantitative_4)(?:(?:еста)|(?:[её]хсот)|(?:[её]мстам)|(?:ьмястами)|(?:[её]хстах)))|(?(quantitative_5)(?:(?:ьсот)|(?:исот)|(?:истам)|(?:ьюстами)|(?:истах)))|(?(quantitative_6)(?:(?:ьсот)|(?:исот)|(?:истам)|(?:ьюстами)|(?:истах)))|(?(quantitative_7)(?:(?:ьсот)|(?:исот)|(?:истам)|(?:ьюстами)|(?:истах)))|(?(quantitative_8)(?:(?:емьсот)|(?:ьмисот)|(?:ьмистам)|(?:емьюстами)|(?:ьмистах)))|(?(quantitative_9)(?:(?:тьсот)|(?:тисот)|(?:тистам)|(?:тьюстами)|(?:тистах)))))(?![а-яёА-ЯЁ]))|(?:(?<![а-яёА-ЯЁ])(?:(?\'ordinal_0\'н[оу]лев)|(?\'ordinal_1\'(?:(?\'ordinal_1_variant_1\'перв)|(?\'ordinal_1_variant_2\'од)))|(?\'ordinal_2\'(?:(?\'ordinal_2_variant_1\'втор)|(?\'ordinal_2_variant_2\'дв)))|(?\'ordinal_3\'(?:(?\'ordinal_3_variant_1\'трет)|(?\'ordinal_3_variant_2\'тр)))|(?\'ordinal_4\'(?:(?\'ordinal_4_variant_1\'четв[её]рт)|(?\'ordinal_4_variant_2\'четыр)))|(?\'ordinal_5\'пят)|(?\'ordinal_6\'шест)|(?\'ordinal_7\'(?:(?\'ordinal_7_variant_1\'седьм)|(?\'ordinal_7_variant_2\'сем)))|(?\'ordinal_8\'(?:(?\'ordinal_8_variant_1\'восьм)|(?\'ordinal_8_variant_2\'восем)))|(?\'ordinal_9\'(?:(?\'ordinal_9_variant_1\'девят)|(?\'ordinal_9_variant_2\'девя)))|(?\'ordinal_10\'десят)|(?\'ordinal_40\'сороков)|(?\'ordinal_100\'сот))(?=[а-яёА-ЯЁ])(?:((?:(?(ordinal_0)|(?(ordinal_2_variant_1)|(?(ordinal_6)|(?(ordinal_7_variant_1)|(?(ordinal_8_variant_1)|(?(ordinal_40)|(*FAIL)))))))(?:(?:ой)|(?:ая)|(?:ое)|(?:ые)|(?:ого)|(?:ых)|(?:ому)|(?:ым)|(?:ую)|(?:ыми)|(?:ом)))|(?:(?(ordinal_1_variant_1)|(?(ordinal_4_variant_1)|(?(ordinal_5)|(?(ordinal_9_variant_1)|(?(ordinal_10)|(?(ordinal_100)|(*FAIL)))))))(?:(?:ый)|(?:ая)|(?:ое)|(?:ые)|(?:ого)|(?:ой)|(?:ых)|(?:ому)|(?:ым)|(?:ую)|(?:ыми)|(?:ом)))|(?:(?(ordinal_3_variant_1)(?:(?:ий)|(?:ья)|(?:ье)|(?:ьи)|(?:ьего)|(?:ьей)|(?:ьею)|(?:ьих)|(?:ьему)|(?:ьим)|(?:ью)|(?:ьими)|(?:ьем))|(*FAIL))))|(?\'ordinal_second_tens\'(?:(?(ordinal_1_variant_2)ин|(?(ordinal_2_variant_2)е|(?(ordinal_3_variant_2)и|(?(ordinal_4_variant_2)|(?(ordinal_5)|(?(ordinal_6)|(?(ordinal_7_variant_2)|(?(ordinal_8_variant_2)|(?(ordinal_9_variant_1)|(*FAIL))))))))))(?:надцат(?:(?:ый)|(?:ая)|(?:ое)|(?:ые)|(?:ого)|(?:ой)|(?:ых)|(?:ому)|(?:ым)|(?:ую)|(?:ыми)|(?:ом)))))|(?\'ordinal_tens\'(?:(?(ordinal_2_variant_2)адцат|(?(ordinal_3_variant_2)идцат|(?(ordinal_5)идесят|(?(ordinal_6)идесят|(?(ordinal_7_variant_2)идесят|(?(ordinal_8_variant_1)идесят|(?(ordinal_9_variant_2)ност|(*FAIL))))))))(?:(?:ый)|(?:ая)|(?:ое)|(?:ые)|(?:ого)|(?:ой)|(?:ых)|(?:ому)|(?:ым)|(?:ую)|(?:ыми)|(?:ом))))|(?\'ordinal_hundreds\'(?:(?(ordinal_2_variant_2)ухсот|(?(ordinal_3_variant_2)[её]хсот|(?(ordinal_4_variant_2)[её]хсот|(?(ordinal_5)исот|(?(ordinal_6)исот|(?(ordinal_7_variant_2)исот|(?(ordinal_8_variant_1)исот|(?(ordinal_9_variant_1)исот|(*FAIL)))))))))(?:(?:ый)|(?:ая)|(?:ое)|(?:ые)|(?:ого)|(?:ой)|(?:ых)|(?:ому)|(?:ым)|(?:ую)|(?:ыми)|(?:ом)))))(?![а-яёА-ЯЁ])))(?:[ ])?)+)\)?)?(?:(?: (?\'calendar_day\'календарн(?:(?:ых)|(?:ый))))|(?: (?\'working_day\'рабоч(?:(?:их)|(?:ий)))))? дн(?:(?:ей)|(?:я))(?(step_number)(*ACCEPT)|(?(step_words)(*ACCEPT)|(*FAIL)))/miu';
            $regexMinPrice = "/(?(DEFINE)(?'rubles_pattern'\d{1,3}(?:[ ]?\d{3})*(?:[,.]\d{2}))(?'rubles_name_pattern'[ ]?(?:(?:рублей)|(?:(?:(?:руб)|(?:р))[\.]?)))(?'percent_pattern'\d+(?:,\d+)?)(?'percent_name_pattern'[ ]?(?:\([а-яёА-ЯЁ]+\))?[ ]?(?:(?:%)|(?:процент(?:ов)?))))(?:(?:(?:(?:мин(?:имальн(?:(?:ая)|(?:ой)))?[\.]?(?: [А-ЯЁа-яё]+)?[ ](?:(?:цен(?:а|ы))|(?:стоимост(?:ь|и))))|(?:цен(?:ы|а|е) отсечения)|(?:прекращается при достижении))).*?(?'new_sentence'(?:\.[ ](?=[А-ЯЁ])).*?(*SKIP))?(?:(?:(?'rubles'(?P>rubles_pattern))(?:(?P>rubles_name_pattern)))|(?:(?'percent'(?P>percent_pattern))(?P>percent_name_pattern)))(?![а-яёА-ЯЁ]))|(?:(?:(?:(?'rubles'(?P>rubles_pattern))(?:(?P>rubles_name_pattern)))|(?:(?'percent'(?P>percent_pattern))(?P>percent_name_pattern)))(?![а-яёА-ЯЁ])(?:.?[ ]?\((?:(?:цена отсечения)|(?:мин(?:имальная)?[\.]?[ ](?:(?:цена)|(?:стоимость)))).*?\)))/muiJ";
            $text = '';
            $min_price = null;
            if (array_key_exists('PriceReduction', $auctionLot) && gettype($auctionLot['PriceReduction']) != 'array' && strlen((string)$auctionLot['PriceReduction']) > 0) {
                $text = $auctionLot['PriceReduction'];
            }
            preg_match_all($regexMinPrice, $text, $matchesPrice, PREG_SET_ORDER, 0);
            $startPrice = $lot->start_price;
            if (count((array)$matchesPrice) > 0 && (array_key_exists('rubles', $matchesPrice[0]) || array_key_exists('percent', $matchesPrice[0]))) {
                $min_price = $this->getMinPrice($matchesPrice, $startPrice);
            } else {
                $text = $fullText;
                preg_match_all($regexMinPrice, $text, $matchesPrice);
                if (count((array)$matchesPrice) > 0 && (array_key_exists('rubles', $matchesPrice[0]) || array_key_exists('percent', $matchesPrice[0]))) {
                    $min_price = $this->getMinPrice($matchesPrice, $startPrice);
                }
            }
            preg_match_all($regexStep, $text, $matchesStep);
            if (count($matchesStep['step_number']) > 0 || count($matchesStep['step_words']) > 0) {
                $step = $this->getPeriod($matchesStep);
                $isWorkingDays = count($matchesStep['working_day']) > 0 && strlen($matchesStep['working_day'][0]) > 0;
            } else {
                $text = $fullText;
                $step = preg_match_all($regexStep, $text, $matchesStep);
                $this->getPeriod($matchesStep);
                $isWorkingDays = count($matchesStep['working_day']) > 0 && strlen($matchesStep['working_day'][0]) > 0;

            }
            if (!is_null($min_price) && $min_price > 0) {
                $lot->min_price = $min_price;
            }
            $priceReduction = new PriceReductionService();
            if (!is_null($min_price) && $min_price > 0 && !is_null($step) && $step > 0 && !is_null($auctionStep) && $auctionStep > 0) {
                if ($isStepPercent) {
                    $percent = $auctionStep;
                    $auctionStep = $startPrice / 100 * $auctionStep;
                } else {
                    $percent = $auctionStep * 100 / $startPrice;
                }
                $startValue = $startPrice;
                if (!$isWorkingDays) {
                    $previousStartPeriod = $lot->auction->application_start_date;
                    $previousEndPeriod = Carbon::parse($lot->auction->application_start_date)->addDays($step);
                    $priceReduction->savePriceReduction($lot->id, $startValue, $previousStartPeriod, $previousEndPeriod, null, $percent);
                    while ($startValue > $min_price) {
                        if ($startValue - $auctionStep > $min_price) {
                            $startValue -= $auctionStep;
                        } else {
                            $startValue = $min_price;
                        }
                        $startPeriodDate = $previousEndPeriod;
                        $endPeriodDate = Carbon::parse($previousEndPeriod)->addDays($step);
                        $priceReduction->savePriceReduction($lot->id, $startValue, $startPeriodDate, $endPeriodDate, null, $percent);
                        $previousEndPeriod = $endPeriodDate;
                    }
                } else {
                    $previousStartPeriod = $lot->auction->application_start_date;
                    $previousEndPeriod = Carbon::parse($lot->auction->application_start_date)->addDays($step);
                    $previousEndPeriod = $this->checkIsWeekend($previousStartPeriod, $previousEndPeriod);
                    $priceReduction->savePriceReduction($lot->id, $startValue, $previousStartPeriod, $previousEndPeriod, null, $percent);
                    while ($startValue > $min_price) {
                        if ($startValue - $auctionStep > $min_price) {
                            $startValue -= $auctionStep;
                        } else {
                            $startValue = $min_price;
                        }
                        $startPeriodDate = $previousEndPeriod;
                        $endPeriodDate = Carbon::parse($previousEndPeriod)->addDays($step);
                        $endPeriodDate = $this->checkIsWeekend($startPeriodDate, $endPeriodDate);
                        $priceReduction->savePriceReduction($lot->id, $startValue, $startPeriodDate, $endPeriodDate, null, $percent);
                        $previousEndPeriod = $endPeriodDate;
                    }
                }

            } else {
                if (array_key_exists('PriceReduction', $auctionLot) && gettype($auctionLot['PriceReduction']) != 'array' && strlen((string)$auctionLot['PriceReduction']) > 0) {
                    $priceReduction->getPriceReduction($auctionLot['PriceReduction'], $lot->id);
                    $prices = $lot->showPriceReductions->pluck('price')->toArray();
                    if (count($prices) > 0) {
                        $lot->min_price = min($prices);
                    }
                }
            }
            $lot->save();
        }
        return $lotNumbers;
    }

    public function getMinPrice($matchesPrices, $startPrice)
    {
        $min_price = null;
        $result = [];
        foreach ($matchesPrices as $matchesPrice) {
            if (array_key_exists('rubles', $matchesPrice) && strlen($matchesPrice['rubles']) > 0) {
                $result[] = (double)str_replace(',', '.', str_replace(' ', '', $matchesPrice['rubles']));
            }
            if (array_key_exists('percent', $matchesPrice) && strlen($matchesPrice['percent']) > 0) {
                $percent = (float)$matchesPrice['percent'];
                $result[] = (double)$startPrice / 100 * $percent;
            }
        }
        $result = array_unique($result);
        if (count($result) == 1) {
            $min_price = $result[0];
        }
        return $min_price;
    }

    public function getPeriod($matchesStep)
    {
        $step = null;
        if (count($matchesStep['step_number']) > 0) {
            foreach ($matchesStep['step_number'] as $step_number) {
                if (strlen($step_number) > 0) {
                    $step = (int)$step_number;
                    break;
                }
            }
        } else if (count($matchesStep['step_words']) > 0) {
            foreach ($matchesStep['step_words'] as $step_words) {
                if (strlen($step_words) > 0) {
                    $step = $this->getNumbersFromWords($step_words);
                    break;
                }
            }
        }
        return $step;
    }


    public function checkIsWeekend($start, $end)
    {
        $period = CarbonPeriod::create($start, $end);
        $dates = $period->toArray();
        $holidays = HolidayDate::all()->pluck('date')->toArray();
        foreach ($dates as $date) {
            if ($date->dayOfWeekIso == 6 || $date->dayOfWeekIso == 7 || in_array($date->format('Y-m-d') . ' 00:00:00', $holidays)) {
                $end = Carbon::parse($end)->addDay();
            }
        }
        return $end;
    }


    public function getNumbersFromWords($words_number)
    {
        $numberRegex = "/(?:(?<![а-яёА-ЯЁ])(?:(?'quantitative_0'н[оу]л)|(?'quantitative_1'од)|(?'quantitative_2'дв)|(?'quantitative_3'тр)|(?'quantitative_4'четыр)|(?'quantitative_5'пят)|(?'quantitative_6'шест)|(?'quantitative_7'сем)|(?'quantitative_8'вос)|(?'quantitative_9'девя)|(?'quantitative_10'десят)|(?'quantitative_40'соро)|(?'quantitative_100'ст))(?=[а-яёА-ЯЁ])(?:((?(quantitative_0)(?:(?:[её]м)|(?:ях)|(?:ями)|(?:ям)|(?:ей)|ь|и|я|ю|е))|(?(quantitative_1)(?:(?:ин)|(?:н(?:(?:ими)|(?:ому)|(?:ого)|(?:ой)|(?:ою)|(?:их)|(?:им)|(?:ом)|о|а|и|у))))|(?(quantitative_2)(?:(?:умя)|(?:ух)|(?:ум)|е|а))|(?(quantitative_3)(?:(?:емя)|(?:[её]х)|(?:[её]м)|и))|(?(quantitative_4)(?:(?:ьмя)|(?:[её]х)|(?:[её]м)|е))|(?(quantitative_5)(?:(?:ью)|ь|и))|(?(quantitative_6)(?:(?:ью)|ь|и))|(?(quantitative_7)(?:(?:ью)|ь|и))|(?(quantitative_8)(?:(?:емь)|(?:[еь]мью)|(?:ьми)))|(?(quantitative_9)(?:(?:тью)|(?:ть)|(?:ти)))|(?(quantitative_10)(?:(?:ью)|ь|и))|(?(quantitative_40)(?:к|(?:ка)))|(?(quantitative_100)(?:о|а)))|(?'quantitative_second_tens'(?(quantitative_1)ин(?:надцат(?:(?:ь)|(?:и)|(?:ью))))|(?(quantitative_2)е(?:надцат(?:(?:ь)|(?:и)|(?:ью))))|(?(quantitative_3)и(?:надцат(?:(?:ь)|(?:и)|(?:ью))))|(?(quantitative_4)(?:надцат(?:(?:ь)|(?:и)|(?:ью))))|(?(quantitative_5)(?:надцат(?:(?:ь)|(?:и)|(?:ью))))|(?(quantitative_6)(?:надцат(?:(?:ь)|(?:и)|(?:ью))))|(?(quantitative_7)(?:надцат(?:(?:ь)|(?:и)|(?:ью))))|(?(quantitative_8)ем(?:надцат(?:(?:ь)|(?:и)|(?:ью))))|(?(quantitative_9)т(?:надцат(?:(?:ь)|(?:и)|(?:ью)))))|(?'quantitative_tens'(?(quantitative_2)адцат(?:(?:ь)|(?:и)|(?:ью)))|(?(quantitative_3)идцат(?:(?:ь)|(?:и)|(?:ью)))|(?(quantitative_5)(?:(?:ьдесят)|(?:идесяти)|(?:ьюдесятью)))|(?(quantitative_6)(?:(?:ьдесят)|(?:идесяти)|(?:ьюдесятью)))|(?(quantitative_7)(?:(?:ьдесят)|(?:идесяти)|(?:ьюдесятью)))|(?(quantitative_8)(?:(?:емьдесят)|(?:ьмидесяти)|(?:ьмьюдесятью)))|(?(quantitative_9)(?:(?:носто)|(?:носта))))|(?'quantitative_hundreds'(?(quantitative_2)(?:(?:ести)|(?:ухсот)|(?:умстам)|(?:умястами)|(?:ухстах)))|(?(quantitative_3)(?:(?:иста)|(?:[её]хсот)|(?:[её]мстам)|(?:емястами)|(?:[её]хстах)))|(?(quantitative_4)(?:(?:еста)|(?:[её]хсот)|(?:[её]мстам)|(?:ьмястами)|(?:[её]хстах)))|(?(quantitative_5)(?:(?:ьсот)|(?:исот)|(?:истам)|(?:ьюстами)|(?:истах)))|(?(quantitative_6)(?:(?:ьсот)|(?:исот)|(?:истам)|(?:ьюстами)|(?:истах)))|(?(quantitative_7)(?:(?:ьсот)|(?:исот)|(?:истам)|(?:ьюстами)|(?:истах)))|(?(quantitative_8)(?:(?:емьсот)|(?:ьмисот)|(?:ьмистам)|(?:емьюстами)|(?:ьмистах)))|(?(quantitative_9)(?:(?:тьсот)|(?:тисот)|(?:тистам)|(?:тьюстами)|(?:тистах)))))(?![а-яёА-ЯЁ]))|(?:(?<![а-яёА-ЯЁ])(?:(?'ordinal_0'н[оу]лев)|(?'ordinal_1'(?:(?'ordinal_1_variant_1'перв)|(?'ordinal_1_variant_2'од)))|(?'ordinal_2'(?:(?'ordinal_2_variant_1'втор)|(?'ordinal_2_variant_2'дв)))|(?'ordinal_3'(?:(?'ordinal_3_variant_1'трет)|(?'ordinal_3_variant_2'тр)))|(?'ordinal_4'(?:(?'ordinal_4_variant_1'четв[её]рт)|(?'ordinal_4_variant_2'четыр)))|(?'ordinal_5'пят)|(?'ordinal_6'шест)|(?'ordinal_7'(?:(?'ordinal_7_variant_1'седьм)|(?'ordinal_7_variant_2'сем)))|(?'ordinal_8'(?:(?'ordinal_8_variant_1'восьм)|(?'ordinal_8_variant_2'восем)))|(?'ordinal_9'(?:(?'ordinal_9_variant_1'девят)|(?'ordinal_9_variant_2'девя)))|(?'ordinal_10'десят)|(?'ordinal_40'сороков)|(?'ordinal_100'сот))(?=[а-яёА-ЯЁ])(?:((?:(?(ordinal_0)|(?(ordinal_2_variant_1)|(?(ordinal_6)|(?(ordinal_7_variant_1)|(?(ordinal_8_variant_1)|(?(ordinal_40)|(*FAIL)))))))(?:(?:ой)|(?:ая)|(?:ое)|(?:ые)|(?:ого)|(?:ых)|(?:ому)|(?:ым)|(?:ую)|(?:ыми)|(?:ом)))|(?:(?(ordinal_1_variant_1)|(?(ordinal_4_variant_1)|(?(ordinal_5)|(?(ordinal_9_variant_1)|(?(ordinal_10)|(?(ordinal_100)|(*FAIL)))))))(?:(?:ый)|(?:ая)|(?:ое)|(?:ые)|(?:ого)|(?:ой)|(?:ых)|(?:ому)|(?:ым)|(?:ую)|(?:ыми)|(?:ом)))|(?:(?(ordinal_3_variant_1)(?:(?:ий)|(?:ья)|(?:ье)|(?:ьи)|(?:ьего)|(?:ьей)|(?:ьею)|(?:ьих)|(?:ьему)|(?:ьим)|(?:ью)|(?:ьими)|(?:ьем))|(*FAIL))))|(?'ordinal_second_tens'(?:(?(ordinal_1_variant_2)ин|(?(ordinal_2_variant_2)е|(?(ordinal_3_variant_2)и|(?(ordinal_4_variant_2)|(?(ordinal_5)|(?(ordinal_6)|(?(ordinal_7_variant_2)|(?(ordinal_8_variant_2)|(?(ordinal_9_variant_1)|(*FAIL))))))))))(?:надцат(?:(?:ый)|(?:ая)|(?:ое)|(?:ые)|(?:ого)|(?:ой)|(?:ых)|(?:ому)|(?:ым)|(?:ую)|(?:ыми)|(?:ом)))))|(?'ordinal_tens'(?:(?(ordinal_2_variant_2)адцат|(?(ordinal_3_variant_2)идцат|(?(ordinal_5)идесят|(?(ordinal_6)идесят|(?(ordinal_7_variant_2)идесят|(?(ordinal_8_variant_1)идесят|(?(ordinal_9_variant_2)ност|(*FAIL))))))))(?:(?:ый)|(?:ая)|(?:ое)|(?:ые)|(?:ого)|(?:ой)|(?:ых)|(?:ому)|(?:ым)|(?:ую)|(?:ыми)|(?:ом))))|(?'ordinal_hundreds'(?:(?(ordinal_2_variant_2)ухсот|(?(ordinal_3_variant_2)[её]хсот|(?(ordinal_4_variant_2)[её]хсот|(?(ordinal_5)исот|(?(ordinal_6)исот|(?(ordinal_7_variant_2)исот|(?(ordinal_8_variant_1)исот|(?(ordinal_9_variant_1)исот|(*FAIL)))))))))(?:(?:ый)|(?:ая)|(?:ое)|(?:ые)|(?:ого)|(?:ой)|(?:ых)|(?:ому)|(?:ым)|(?:ую)|(?:ыми)|(?:ом)))))(?![а-яёА-ЯЁ]))/";
        $numbersArray = explode(' ', $words_number);
        $rules = [
            'quantitative_0' => 0,
            'quantitative_1' => 1,
            'quantitative_2' => 2,
            'quantitative_3' => 3,
            'quantitative_4' => 4,
            'quantitative_5' => 5,
            'quantitative_6' => 6,
            'quantitative_7' => 7,
            'quantitative_8' => 8,
            'quantitative_9' => 9,
            'quantitative_10' => 10,
            'quantitative_40' => 40,
            'quantitative_100' => 100,
            'quantitative_second_tens' => 10,
            'quantitative_tens' => 10,
            'quantitative_hundreds' => 100,
            'ordinal_0' => 0,
            'ordinal_1' => 1,
            'ordinal_2' => 2,
            'ordinal_3' => 3,
            'ordinal_4' => 4,
            'ordinal_5' => 5,
            'ordinal_6' => 6,
            'ordinal_7' => 7,
            'ordinal_8' => 8,
            'ordinal_9' => 9,
            'ordinal_0_variant_1' => 0,
            'ordinal_1_variant_1' => 1,
            'ordinal_2_variant_1' => 2,
            'ordinal_3_variant_1' => 3,
            'ordinal_4_variant_1' => 4,
            'ordinal_5_variant_1' => 5,
            'ordinal_6_variant_1' => 6,
            'ordinal_7_variant_1' => 7,
            'ordinal_8_variant_1' => 8,
            'ordinal_9_variant_1' => 9,
            'ordinal_0_variant_2' => 0,
            'ordinal_1_variant_2' => 1,
            'ordinal_2_variant_2' => 2,
            'ordinal_3_variant_2' => 3,
            'ordinal_4_variant_2' => 4,
            'ordinal_5_variant_2' => 5,
            'ordinal_6_variant_2' => 6,
            'ordinal_7_variant_2' => 7,
            'ordinal_8_variant_2' => 8,
            'ordinal_9_variant_2' => 9,
            'ordinal_10' => 10,
            'ordinal_40' => 40,
            'ordinal_100' => 100,
            'ordinal_second_tens' => 10,
            'ordinal_tens' => 10,
            'ordinal_hundreds' => 100
        ];
        $numbers = [];
        try {
            foreach ($numbersArray as $number) {
                preg_match_all($numberRegex, $number, $matches);
                $result = [];
                foreach ($matches as $key => $match) {
                    if (array_key_exists($key, $rules) && strlen($match[0]) > 0) {
                        if (strpos($key, 'second_tens')) {
                            $result['tens_plus_number'] = $rules[$key];
                        } elseif (strpos($key, 'tens') || strpos($key, 'hundreds')) {
                            $result['number_mul_number'] = $rules[$key];
                        } else {
                            $result['number'] = $rules[$key];
                        }
                    }
                }
                if (count($result) > 0) {
                    if (array_key_exists('tens_plus_number', $result) && array_key_exists('number', $result)) {
                        $numbers[] = $result['tens_plus_number'] + $result['number'];
                    } elseif (array_key_exists('number_mul_number', $result) && array_key_exists('number', $result)) {
                        $numbers[] = $result['number_mul_number'] * $result['number'];
                    } else {
                        $numbers[] = $result['number'];
                    }
                }
            }
        } catch (Exception $e) {

        }
        $number = null;
        if (count($numbers) > 0) {
            $number = 0;
            foreach ($numbers as $val) {
                $number += $val;
            }
        }
        return $number;
    }


}
