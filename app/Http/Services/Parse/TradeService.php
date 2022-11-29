<?php

namespace App\Http\Services\Parse;

use App\Models\Category;
use App\Models\Lot;
use App\Models\LotFile;
use App\Models\LotParam;
use App\Models\Param;
use App\Models\PriceReduction;
use Carbon\Carbon;
use Exception;

class TradeService
{
    protected $value;
    protected $prefix;
    protected $files;
    protected $images;
    protected $lot;
    protected $tradeMessageId;
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

    public function __construct($auction, $value, $prefix, $tradeMessageId, $files = null, $images = null)
    {
        if ($auction->lots->where('number', $value['@attributes']['LotNumber'])->count() == 0) {
            $lot = new Lot();
            $lot->auction_id = $auction->id;
        } else {
            $lot = $auction->lots->where('number', $value['@attributes']['LotNumber'])->first();
        }
        $this->lot = $lot;
        $this->value = $value;
        $this->prefix = $prefix;
        $this->files = $files;
        $this->images = $images;
        $this->tradeMessageId = $tradeMessageId;
    }


    public function saveLot()
    {
        $lot = $this->lot;
        $prefix = $this->prefix;
        $value = $this->value;

        $lot->number = $value['@attributes']['LotNumber'];
        $lot->start_price = array_key_exists($prefix . 'StartPrice', $value) ? $value[$prefix . 'StartPrice'] : 0;
        if (array_key_exists($prefix . 'AdvancePercent', $value)) {
            $lot->deposit = gettype($value[$prefix . 'AdvancePercent']) == 'array' ? NULL : $value[$prefix . 'AdvancePercent'];
            $lot->is_deposit_rub = false;
        } elseif (array_key_exists('Advance', $value)) {
            $lot->deposit = gettype($value['Advance']) == 'array' ? NULL : $value['Advance'];
        }
        if (array_key_exists($prefix . 'StepPricePercent', $value)) {
            $lot->auction_step = gettype($value[$prefix . 'StepPricePercent']) == 'array' ? NULL : $value[$prefix . 'StepPricePercent'];
            $lot->is_step_rub = false;
        } elseif (array_key_exists($prefix . 'StepPrice', $value)) {
            $lot->auction_step = gettype($value[$prefix . 'StepPrice']) == 'array' ? NULL : $value[$prefix . 'StepPrice'];
        }
        $lot->status_id = 1;
        if (array_key_exists($prefix . 'Participants', $value)) {
            if (gettype($value[$prefix . 'Participants']) == 'array' && count($value[$prefix . 'Participants']) > 0) {
                if (gettype($value[$prefix . 'Participants'][$prefix . 'PaymentInfo']) == 'string') {
                    $lot->payment_info = stripslashes(preg_replace('/[\x00-\x1F\x7F]/u', ' ', $value[$prefix . 'Participants'][$prefix . 'PaymentInfo']));
                }
                if (gettype($value[$prefix . 'Participants'][$prefix . 'SaleAgreement']) == 'string') {
                    $lot->sale_agreement = stripslashes(preg_replace('/[\x00-\x1F\x7F]/u', ' ', $value[$prefix . 'Participants'][$prefix . 'SaleAgreement']));
                }
            }
        }
        if (array_key_exists($prefix . 'Participants', $value) && gettype($value[$prefix . 'Participants']) == 'string') {
            $lot->participants = stripslashes(preg_replace('/[\x00-\x1F\x7F]/u', ' ', $value[$prefix . 'Participants']));
        }
        if (array_key_exists($prefix . 'SaleAgreement', $value) && gettype($value[$prefix . 'SaleAgreement']) == 'string') {
            $lot->sale_agreement = stripslashes(preg_replace('/[\x00-\x1F\x7F]/u', ' ', $value[$prefix . 'SaleAgreement']));
        }
        if (array_key_exists($prefix . 'PaymentInfo', $value) && gettype($value[$prefix . 'PaymentInfo']) == 'string') {
            $lot->payment_info = stripslashes(preg_replace('/[\x00-\x1F\x7F]/u', ' ', $value[$prefix . 'PaymentInfo']));
        }

        if (array_key_exists($prefix . 'Concours', $value) && gettype($value[$prefix . 'Concours']) == 'string') {
            $lot->payment_info = $value[$prefix . 'Concours'];
        }
        $lot->created_at = Carbon::now()->setTimezone('Europe/Moscow');
        $lot->description = array_key_exists($prefix . 'TradeObjectHtml', $value) ? stripslashes(preg_replace('/[\x00-\x1F\x7F]/u', ' ', $value[$prefix . 'TradeObjectHtml'])) : NULL;
        $lot->save();
        $region = $lot->auction->debtor->region;
        if ($region && !$lot->regions->contains($region)) {
            $lot->regions()->attach($region, ['is_debtor_region' => true]);
        }
        if (!is_null($this->files)) {
            foreach ($this->files as $file) {
                $this->saveFiles($file, 'file');
            }
        }

        if (!is_null($this->images)) {
            foreach ($this->images as $image) {
                $this->saveFiles($image, 'image');
            }
        }

        if (gettype($value[$prefix . 'Classification'][$prefix . 'IDClass']) == 'array') {
            foreach ($value[$prefix . 'Classification'][$prefix . 'IDClass'] as $item) {
                $category = Category::where('code', $item)->first();
                if ($category) {
                    if (!$lot->categories()->where('title', $category->title)->exists()) {
                        $lot->categories()->attach($category);
                    }
                }
            }
        } else {
            $category = Category::where('code', $value[$prefix . 'Classification'][$prefix . 'IDClass'])->first();
            if (!$lot->categories()->where('title', $category->title)->exists()) {
                $lot->categories()->attach($category);
            }
        }

        if ($lot->categories()->count() == 0) {
            $category = Category::where('code', '99')->first();
            $lot->categories()->attach($category);
        }
        if (array_key_exists($prefix . 'TradeObjectHtml', $value)) {
            $cadastr_number = '/\d{2}:\d{2}:\d{1,7}:\d{1,}/';
            preg_match_all($cadastr_number, $value[$prefix . 'TradeObjectHtml'], $matches);
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
            preg_match_all($avto_number, $value[$prefix . 'TradeObjectHtml'], $matches);
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
            preg_match_all($avto_vin, $value[$prefix . 'TradeObjectHtml'], $matches);
            if (count($matches[0]) > 0) {
                $mainParam->save();
                foreach (array_unique($matches[0]) as $match) {
                    $lot->params()->attach(Param::find(6), ['value' => $match, 'parent_id' => $mainParam->id]);
                }
            }
        }
        $this->savePriceReduction($lot->id, $lot->start_price, $lot->created_at, null, null, 0, 0, true);
        if (array_key_exists($prefix . 'PriceReduction', $value)) {
            $this->getPriceReduction($value[$prefix . 'PriceReduction'], $lot->id);
            $lot->price_reduction = $value[$prefix . 'PriceReduction'];
            $lot->save();
        }

        return $lot;

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

    public function saveFiles($file, $type)
    {
        $lot = $this->lot;
        if (!LotFile::where(['url' => json_encode($file), 'lot_id' => $lot->id, 'type' => $type])->exists()) {
            LotFile::create([
                'url' => json_encode($file),
                'type' => $type,
                'lot_id' => $lot->id,
                'trade_message_id' => $this->tradeMessageId
            ]);
        }
    }

    public function getPriceReduction($red, $lot_id)
    {
        try {
            $lot = Lot::find($lot_id);
            if (str_starts_with($red, '&lt;table&gt;&lt;')) {
                $red = htmlspecialchars_decode($red);
            }
            if (str_starts_with($red, '<table><tr><td><b>')) {
                $pattern = '/<tr[\s\S]*?<\/tr>/';
                preg_match_all($pattern, $red, $matches);
                if (count($matches[0]) > 0) {
                    unset($matches[0][0]);
                    $this->getPriceReductionParams($matches, 0, 3, 6, $lot, 5);
                }
            } elseif (str_starts_with($red, '<table><thead><tr><td>')) {
                $pattern = '/<tr[\s\S]*?<\/tr>/';
                preg_match_all($pattern, $red, $matches);
                if (count($matches[0]) > 0) {
                    unset($matches[0][0]);
                    $this->getPriceReductionParams($matches, 3, 4, 1, $lot, 2);
                }
            } elseif (str_starts_with($red, '<table><thead><tr><th>')) {
                $pattern = '/<tr[\s\S]*?<\/tr>/';
                preg_match_all($pattern, $red, $matches);
                if (count($matches[0]) > 0) {
                    unset($matches[0][0]);
                    $this->getPriceReductionParams($matches, 0, 3, 5, $lot, 4);
                } elseif (str_starts_with($red, '<table><tr><td>')) {
                    $pattern = '/<tr[\s\S]*?<\/tr>/';
                    preg_match_all($pattern, $red, $matches);
                    if (count($matches[0]) > 0) {
                        $this->getPriceReductionParams($matches, 0, 1, 2, $lot);
                    }
                } else {
                    try {
                        $values = explode('<br/>', $red);
                        $i = 1;
                        foreach ($values as $value) {
                            $items = explode(': ', $value);
                            if (count($items) > 1) {
                                $price = (float)$items[1];
                                if (date('Y-m-d H:i:s', strtotime($items[0]) == $items[0]) && $price != 0) {
                                    if ($i < count($values) - 1) {
                                        $next_item = explode(': ', $values[$i + 1]);
                                        $time_end = $next_item[0];
                                    } else {
                                        $time_end = $lot->auction->result_date;
                                    }
                                    if ($i > 1) {
                                        $prev_item = explode(': ', $values[$i - 1]);
                                        $prev_price = (float)$prev_item[1];
                                    } else {
                                        $prev_price = $lot->start_price;
                                    }
                                    $this->savePriceReduction($lot_id, $price, $items[0], $time_end, $prev_price);
                                }
                            }
                            $i++;
                        }
                    } catch (Exception $e) {
                    }
                }
                if (PriceReduction::where('lot_id', $lot->id)->count() == 0) {
                    $this->savePriceReduction($lot->id, $lot->start_price, $lot->auction->event_start_date, $lot->auction->event_end_date, null, 0, 0, true);
                }
            }
        } catch
        (Exception $e) {
            logger('e: ' . $e);
            logger($red);
        }
    }

    public function getPriceReductionParams($matches, $start_time_index, $end_time_index, $price_index, $lot, $deposit_index = null)
    {
        $i = 0;
        foreach ($matches[0] as $match) {
            $new_pattern = '/<td[\s\S]*?<\/td>/';
            preg_match_all($new_pattern, $match, $items);
            $start_time = substr($items[0][$start_time_index], 4, strlen($items[0][$start_time_index]) - 9);
            $end_time = substr($items[0][$end_time_index], 4, strlen($items[0][$end_time_index]) - 9);
            $price = array_key_exists((string)$price_index, $items[0]) ? number_format((float)preg_replace("/[^,.0-9]/", '',
                str_replace(',', '.',
                    substr($items[0][$price_index], 4, strlen($items[0][$price_index]) - 9)
                )), 2, '.', '') : 0;
            $deposit = null;
            if (!is_null($deposit_index)) {
                $deposit = array_key_exists((string)$deposit_index, $items[0]) ? number_format((float)preg_replace("/[^,.0-9]/", '',
                    str_replace(',', '.',
                        substr($items[0][$deposit_index], 4, strlen($items[0][$deposit_index]) - 9)
                    )), 2, '.', '') : null;
            }
            if ($i > 1) {
                preg_match_all($new_pattern, $matches[0][$i - 1], $prev_item);
                $prev_price = array_key_exists((string)$price_index, $items[0]) ? (float)preg_replace("/[^,.0-9]/", '',
                    str_replace(',', '.',
                        substr($prev_item[0][$price_index], 4, strlen($prev_item[0][$price_index]) - 9))) : 0;
            } else {
                $prev_price = $lot->start_price;
            }
            if (date('Y-m-d H:i:s', strtotime($start_time) == $start_time) && $price > 0
                && date('Y-m-d H:i:s', strtotime($end_time) == $end_time)) {
                $this->savePriceReduction($lot->id, $price, $start_time, $end_time, $prev_price, 0, $deposit);
            }
            $i++;
        }
    }

    public function savePriceReduction($lot_id, $price, $start_time, $end_time, $prev_price = null, $percent = 0, $deposit = 0, $is_system = false)
    {
        if (!is_null($prev_price)) {
            $percent = ((float)$prev_price - (float)$price) / (float)$prev_price * 100;
        }
        PriceReduction::create([
            'lot_id' => $lot_id,
            'price' => $price,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'percent' => $percent,
            'deposit' => $deposit,
            'is_system' => $is_system
        ]);
    }

}
