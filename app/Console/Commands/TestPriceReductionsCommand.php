<?php

namespace App\Console\Commands;

use App\Http\Services\Parse\SoapWrapperService;
use App\Models\HolidayDate;
use App\Models\Lot;
use App\Models\TestMessage;
use Artisaninweb\SoapWrapper\SoapWrapper;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Exception;
use Illuminate\Console\Command;
use Midnite81\Xml2Array\Xml2Array;

class TestPriceReductionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:price-reds';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $value = ['PublicOffer', 'ClosePublicOffer'];
        $lots = Lot::whereHas('auction.auctionType', function ($q) use ($value) {
            $q->whereIn('title', $value);
        })->latest()->limit(2000)->get();
        foreach ($lots as $lot) {
            try {
                $bidInv = $lot->tradeMessages()->where('value', 'biddingDeclared')->first();
                $soapWrapper = new SoapWrapper();
                $service = new SoapWrapperService($soapWrapper);
                $xmlBid = $service->getTradeMessageContent($bidInv->number);
                $xmlBid = Xml2Array::create($xmlBid)->toArray();
                $type = 'BiddingInvitation';
                $key = preg_grep('/:Body/', array_keys($xmlBid));
                if (array_key_exists('ns1:Set' . $type, $xmlBid[$key[0]])) {
                    $invitation = $xmlBid[$key[0]]['ns1:Set' . $type]['ns1:' . $type];
                    $prefix = 'ns1:';
                } else {
                    $invitation = $xmlBid[$key[0]]['Set' . $type][$type];
                    $prefix = '';
                }
                $id = $invitation[$prefix . 'IDEFRSB'];
                $xml = $service->getMessageContent($id);
                $xml = Xml2Array::create($xml)->toArray();
                $test = new TestMessage();
                $test->lot_id = $lot->id;
                $test->message_id = $xml['Id'];
                try {
                    try {
                        $text = null;
                        $lots = [];
                        if (array_key_exists('Auction', $xml['MessageInfo'])) {
                            $lots = $xml['MessageInfo']['Auction']['LotTable']['AuctionLot'];
                            $text = $xml['MessageInfo']['Auction']['Text'];
                        } elseif (array_key_exists('ChangeAuction', $xml['MessageInfo'])) {
                            $lots = $xml['MessageInfo']['ChangeAuction']['LotTable']['AuctionLot'];
                            $text = $xml['MessageInfo']['ChangeAuction']['Text'];
                        } elseif (array_key_exists('Auction2', $xml['MessageInfo'])) {
                            $lots = $xml['MessageInfo']['Auction2']['LotTable']['AuctionLot'];
                            $text = $xml['MessageInfo']['Auction2']['Text'];
                        }
                        if (array_key_exists('Order', $lots)) {
                            $auctionLot = $lots;
                            $this->storeData($auctionLot, $lot, $test, $text);
                        } else {
                            foreach ($lots as $auctionLot) {
                                $this->storeData($auctionLot, $lot, $test, $text);
                            }
                        }

                    } catch (\Exception $e) {
                        logger($e);
                        logger($lots);
                        logger($xml);
                    }
                    // }
                } catch (\Exception $e) {
                    logger($e);
                    logger($lot->id);
                    logger($xml);
                }

            } catch (\Exception $e) {
                logger($e);
                logger($lot->id);
            }
        }
        return 0;
    }

    public function storeData($auctionLot, $lot, $test, $fullText)
    {

        if ($auctionLot['Order'] == $lot->number) {
            $test->start_price = $auctionLot['StartPrice'];

            $auctionStep = null;
            $isStepPercent = false;
            if (array_key_exists('Step', $auctionLot) && gettype($auctionLot['Step']) != 'array' && strlen((string)$auctionLot['Step']) > 0) {
                $test->auction_step = $auctionLot['Step'];
                $auctionStep = $auctionLot['Step'];
            } else {
                $test->auction_step = $lot->auction_step;
                $auctionStep = $lot->auction_step;
                $isStepPercent = !$lot->is_step_rub;
            }
            if (array_key_exists('AuctionStepUnit', $auctionLot) && gettype($auctionLot['AuctionStepUnit']) != 'array' && strlen((string)$auctionLot['AuctionStepUnit']) > 0) {
                $test->auction_step_unit = $auctionLot['AuctionStepUnit'];
                $isStepPercent = $auctionLot['AuctionStepUnit'] == 'Percent';
            }
            if (array_key_exists('Description', $auctionLot) && gettype($auctionLot['Description']) != 'array' && strlen((string)$auctionLot['Description']) > 0) {
                $test->description = $auctionLot['Description'];
                $params = $lot->params()->whereIn('param_id', [4, 5, 6])->pluck('value');
                if (count($params) > 0) {
                    $changeDesc = $auctionLot['Description'];
                    foreach ($params as $param) {
                        $changeDesc = str_replace($param, str_repeat('░', strlen($param) - 1), $changeDesc);
                    }
                    $test->change_desc = $changeDesc;
                }
            }
            $regexStep = '/(?:(?:(?:снижается)|(?:понижается)|(?:снижения)|(?:уменьшается)|(?:кажды(?:х|е))).*?)(?\'step_number\'\d+)?(?:[ ]?\(?(?\'step_words\'(?:(?:(?:(?<![а-яёА-ЯЁ])(?:(?\'quantitative_0\'н[оу]л)|(?\'quantitative_1\'од)|(?\'quantitative_2\'дв)|(?\'quantitative_3\'тр)|(?\'quantitative_4\'четыр)|(?\'quantitative_5\'пят)|(?\'quantitative_6\'шест)|(?\'quantitative_7\'сем)|(?\'quantitative_8\'вос)|(?\'quantitative_9\'девя)|(?\'quantitative_10\'десят)|(?\'quantitative_40\'соро)|(?\'quantitative_100\'ст))(?=[а-яёА-ЯЁ])(?:((?(quantitative_0)(?:(?:[её]м)|(?:ях)|(?:ями)|(?:ям)|(?:ей)|ь|и|я|ю|е))|(?(quantitative_1)(?:(?:ин)|(?:н(?:(?:ими)|(?:ому)|(?:ого)|(?:ой)|(?:ою)|(?:их)|(?:им)|(?:ом)|о|а|и|у))))|(?(quantitative_2)(?:(?:умя)|(?:ух)|(?:ум)|е|а))|(?(quantitative_3)(?:(?:емя)|(?:[её]х)|(?:[её]м)|и))|(?(quantitative_4)(?:(?:ьмя)|(?:[её]х)|(?:[её]м)|е))|(?(quantitative_5)(?:(?:ью)|ь|и))|(?(quantitative_6)(?:(?:ью)|ь|и))|(?(quantitative_7)(?:(?:ью)|ь|и))|(?(quantitative_8)(?:(?:емь)|(?:[еь]мью)|(?:ьми)))|(?(quantitative_9)(?:(?:тью)|(?:ть)|(?:ти)))|(?(quantitative_10)(?:(?:ью)|ь|и))|(?(quantitative_40)(?:к|(?:ка)))|(?(quantitative_100)(?:о|а)))|(?\'quantitative_second_tens\'(?(quantitative_1)ин(?:надцат(?:(?:ь)|(?:и)|(?:ью))))|(?(quantitative_2)е(?:надцат(?:(?:ь)|(?:и)|(?:ью))))|(?(quantitative_3)и(?:надцат(?:(?:ь)|(?:и)|(?:ью))))|(?(quantitative_4)(?:надцат(?:(?:ь)|(?:и)|(?:ью))))|(?(quantitative_5)(?:надцат(?:(?:ь)|(?:и)|(?:ью))))|(?(quantitative_6)(?:надцат(?:(?:ь)|(?:и)|(?:ью))))|(?(quantitative_7)(?:надцат(?:(?:ь)|(?:и)|(?:ью))))|(?(quantitative_8)ем(?:надцат(?:(?:ь)|(?:и)|(?:ью))))|(?(quantitative_9)т(?:надцат(?:(?:ь)|(?:и)|(?:ью)))))|(?\'quantitative_tens\'(?(quantitative_2)адцат(?:(?:ь)|(?:и)|(?:ью)))|(?(quantitative_3)идцат(?:(?:ь)|(?:и)|(?:ью)))|(?(quantitative_5)(?:(?:ьдесят)|(?:идесяти)|(?:ьюдесятью)))|(?(quantitative_6)(?:(?:ьдесят)|(?:идесяти)|(?:ьюдесятью)))|(?(quantitative_7)(?:(?:ьдесят)|(?:идесяти)|(?:ьюдесятью)))|(?(quantitative_8)(?:(?:емьдесят)|(?:ьмидесяти)|(?:ьмьюдесятью)))|(?(quantitative_9)(?:(?:носто)|(?:носта))))|(?\'quantitative_hundreds\'(?(quantitative_2)(?:(?:ести)|(?:ухсот)|(?:умстам)|(?:умястами)|(?:ухстах)))|(?(quantitative_3)(?:(?:иста)|(?:[её]хсот)|(?:[её]мстам)|(?:емястами)|(?:[её]хстах)))|(?(quantitative_4)(?:(?:еста)|(?:[её]хсот)|(?:[её]мстам)|(?:ьмястами)|(?:[её]хстах)))|(?(quantitative_5)(?:(?:ьсот)|(?:исот)|(?:истам)|(?:ьюстами)|(?:истах)))|(?(quantitative_6)(?:(?:ьсот)|(?:исот)|(?:истам)|(?:ьюстами)|(?:истах)))|(?(quantitative_7)(?:(?:ьсот)|(?:исот)|(?:истам)|(?:ьюстами)|(?:истах)))|(?(quantitative_8)(?:(?:емьсот)|(?:ьмисот)|(?:ьмистам)|(?:емьюстами)|(?:ьмистах)))|(?(quantitative_9)(?:(?:тьсот)|(?:тисот)|(?:тистам)|(?:тьюстами)|(?:тистах)))))(?![а-яёА-ЯЁ]))|(?:(?<![а-яёА-ЯЁ])(?:(?\'ordinal_0\'н[оу]лев)|(?\'ordinal_1\'(?:(?\'ordinal_1_variant_1\'перв)|(?\'ordinal_1_variant_2\'од)))|(?\'ordinal_2\'(?:(?\'ordinal_2_variant_1\'втор)|(?\'ordinal_2_variant_2\'дв)))|(?\'ordinal_3\'(?:(?\'ordinal_3_variant_1\'трет)|(?\'ordinal_3_variant_2\'тр)))|(?\'ordinal_4\'(?:(?\'ordinal_4_variant_1\'четв[её]рт)|(?\'ordinal_4_variant_2\'четыр)))|(?\'ordinal_5\'пят)|(?\'ordinal_6\'шест)|(?\'ordinal_7\'(?:(?\'ordinal_7_variant_1\'седьм)|(?\'ordinal_7_variant_2\'сем)))|(?\'ordinal_8\'(?:(?\'ordinal_8_variant_1\'восьм)|(?\'ordinal_8_variant_2\'восем)))|(?\'ordinal_9\'(?:(?\'ordinal_9_variant_1\'девят)|(?\'ordinal_9_variant_2\'девя)))|(?\'ordinal_10\'десят)|(?\'ordinal_40\'сороков)|(?\'ordinal_100\'сот))(?=[а-яёА-ЯЁ])(?:((?:(?(ordinal_0)|(?(ordinal_2_variant_1)|(?(ordinal_6)|(?(ordinal_7_variant_1)|(?(ordinal_8_variant_1)|(?(ordinal_40)|(*FAIL)))))))(?:(?:ой)|(?:ая)|(?:ое)|(?:ые)|(?:ого)|(?:ых)|(?:ому)|(?:ым)|(?:ую)|(?:ыми)|(?:ом)))|(?:(?(ordinal_1_variant_1)|(?(ordinal_4_variant_1)|(?(ordinal_5)|(?(ordinal_9_variant_1)|(?(ordinal_10)|(?(ordinal_100)|(*FAIL)))))))(?:(?:ый)|(?:ая)|(?:ое)|(?:ые)|(?:ого)|(?:ой)|(?:ых)|(?:ому)|(?:ым)|(?:ую)|(?:ыми)|(?:ом)))|(?:(?(ordinal_3_variant_1)(?:(?:ий)|(?:ья)|(?:ье)|(?:ьи)|(?:ьего)|(?:ьей)|(?:ьею)|(?:ьих)|(?:ьему)|(?:ьим)|(?:ью)|(?:ьими)|(?:ьем))|(*FAIL))))|(?\'ordinal_second_tens\'(?:(?(ordinal_1_variant_2)ин|(?(ordinal_2_variant_2)е|(?(ordinal_3_variant_2)и|(?(ordinal_4_variant_2)|(?(ordinal_5)|(?(ordinal_6)|(?(ordinal_7_variant_2)|(?(ordinal_8_variant_2)|(?(ordinal_9_variant_1)|(*FAIL))))))))))(?:надцат(?:(?:ый)|(?:ая)|(?:ое)|(?:ые)|(?:ого)|(?:ой)|(?:ых)|(?:ому)|(?:ым)|(?:ую)|(?:ыми)|(?:ом)))))|(?\'ordinal_tens\'(?:(?(ordinal_2_variant_2)адцат|(?(ordinal_3_variant_2)идцат|(?(ordinal_5)идесят|(?(ordinal_6)идесят|(?(ordinal_7_variant_2)идесят|(?(ordinal_8_variant_1)идесят|(?(ordinal_9_variant_2)ност|(*FAIL))))))))(?:(?:ый)|(?:ая)|(?:ое)|(?:ые)|(?:ого)|(?:ой)|(?:ых)|(?:ому)|(?:ым)|(?:ую)|(?:ыми)|(?:ом))))|(?\'ordinal_hundreds\'(?:(?(ordinal_2_variant_2)ухсот|(?(ordinal_3_variant_2)[её]хсот|(?(ordinal_4_variant_2)[её]хсот|(?(ordinal_5)исот|(?(ordinal_6)исот|(?(ordinal_7_variant_2)исот|(?(ordinal_8_variant_1)исот|(?(ordinal_9_variant_1)исот|(*FAIL)))))))))(?:(?:ый)|(?:ая)|(?:ое)|(?:ые)|(?:ого)|(?:ой)|(?:ых)|(?:ому)|(?:ым)|(?:ую)|(?:ыми)|(?:ом)))))(?![а-яёА-ЯЁ])))(?:[ ])?)+)\)?)?(?:(?: (?\'calendar_day\'календарн(?:(?:ых)|(?:ый))))|(?: (?\'working_day\'рабоч(?:(?:их)|(?:ий)))))? дн(?:(?:ей)|(?:я))(?(step_number)(*ACCEPT)|(?(step_words)(*ACCEPT)|(*FAIL)))/miu';
            $regexMinPrice = "/(?:(?:(?:минимальн(?:(?:ая)|(?:ой)) цен(?:а|ы))|(?:цен(?:ы|а) отсечения))).*?(?:(?:(?'rubles'\d{1,3}(?:[ ]?\d{3})*(?:[,]\d{2})*)(?: (?:(?:рублей)|(?:(?:(?:руб)|(?:р))[\.]?))))|(?:(?'percent'\d+(?:,\d+)?)[ ]?(?:\([а-яёА-ЯЁ]+\))?[ ]?(?:(?:%)|(?:процент(?:ов)?))))(?![а-яёА-ЯЁ])/miu";
            $text = '';
            if (array_key_exists('PriceReduction', $auctionLot) && gettype($auctionLot['PriceReduction']) != 'array' && strlen((string)$auctionLot['PriceReduction']) > 0) {
                $text = $auctionLot['PriceReduction'];
            }
            $test->text = $fullText;
            preg_match_all($regexMinPrice, $text, $matchesPrice, PREG_SET_ORDER, 0);
            $min_price = null;
            $step = null;
            $isWorkingDays = false;
            $startPrice = $lot->start_price;
            if (count($matchesPrice['rubles']) > 0 || count($matchesPrice['percent']) > 0) {
                $min_price = $this->getMinPrice($matchesPrice, $startPrice);
            } else {
                $text = $fullText;
                preg_match_all($regexMinPrice, $text, $matchesPrice, PREG_SET_ORDER, 0);
                $min_price = $this->getMinPrice($matchesPrice, $startPrice);
            }
            preg_match_all($regexStep, $text, $matchesStep);
            if (count($matchesStep['step_number']) > 0 || count($matchesStep['step_words']) > 0) {
                $step = $this->getPeriod($matchesStep, $test);
                $isWorkingDays = count($matchesStep['working_day']) > 0 && strlen($matchesStep['working_day'][0]) > 0;
            } else {
                $text = $fullText;
                $step = preg_match_all($regexStep, $text, $matchesStep);
                $this->getPeriod($matchesStep, $test);
                $isWorkingDays = count($matchesStep['working_day']) > 0 && strlen($matchesStep['working_day'][0]) > 0;

            }
            logger('-----');
            $test->min_price = $min_price;
            if (!is_null($min_price) && $min_price > 0 && !is_null($step) && $step > 0 && !is_null($auctionStep) && $auctionStep > 0) {
                $resultPriceRed = [];
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
                    $resultPriceRed[] = [
                        'price' => $startValue,
                        'start_date' => $previousStartPeriod,
                        'end_date' => $previousEndPeriod,
                        'percent' => $percent
                    ];
                    while ($startValue > $min_price) {
                        $startValue -= $auctionStep;
                        $startPeriodDate = $previousEndPeriod;
                        $endPeriodDate = Carbon::parse($previousEndPeriod)->addDays($step);
                        $resultPriceRed[] = [
                            'price' => $startValue,
                            'start_date' => $startPeriodDate,
                            'end_date' => $endPeriodDate,
                            'percent' => $percent
                        ];
                        $previousEndPeriod = $endPeriodDate;
                    }
                } else {
                    $previousStartPeriod = $lot->auction->application_start_date;
                    $previousEndPeriod = Carbon::parse($lot->auction->application_start_date)->addDays($step);
                    $previousEndPeriod = $this->checkIsWeekend($previousStartPeriod, $previousEndPeriod);

                    $resultPriceRed[] = [
                        'price' => $startValue,
                        'start_date' => $previousStartPeriod,
                        'end_date' => $previousEndPeriod,
                        'percent' => $percent
                    ];
                    while ($startValue > $min_price) {
                        $startValue -= $auctionStep;
                        $startPeriodDate = $previousEndPeriod;
                        $endPeriodDate = Carbon::parse($previousEndPeriod)->addDays($step);
                        $endPeriodDate = $this->checkIsWeekend($startPeriodDate, $endPeriodDate);
                        $resultPriceRed[] = [
                            'price' => $startValue,
                            'start_date' => $startPeriodDate,
                            'end_date' => $endPeriodDate,
                            'percent' => $percent
                        ];
                        $previousEndPeriod = $endPeriodDate;
                    }
                }
                $test->price_red_json = $resultPriceRed;

            } else {
                if (array_key_exists('PriceReduction', $auctionLot) && gettype($auctionLot['PriceReduction']) != 'array' && strlen((string)$auctionLot['PriceReduction']) > 0) {
                    $this->getPriceReduction($auctionLot['PriceReduction'], $lot->id, $test);
                    if (count($test->price_red_json) > 0) {
                        foreach ($test->price_red_json as $key => $val) {
                            if (count($test->price_red_json) - 1 <= $key + 1) {
                                if ($val['price'] < $test->price_red_json[$key + 1]['price']) {
                                    $test->min_price = $val['price'];
                                }
                            } else {
                                $test->min_price = $test->price_red_json[$key + 1];
                            }
                        }
                    }
                }
            }
            if (array_key_exists('PriceReduction', $auctionLot) && gettype($auctionLot['PriceReduction']) != 'array' && strlen((string)$auctionLot['PriceReduction']) > 0) {
                $test->price_reduction = $auctionLot['PriceReduction'];
            }
            $test->save();
        }


    }

    public function getMinPrice($matchesPrice, $startPrice)
    {
        $min_price = null;
        if (count($matchesPrice['rubles']) > 0) {
            foreach ($matchesPrice['rubles'] as $ruble) {
                if (strlen($ruble) > 0) {
                    $min_price = (double)str_replace(',', '.', str_replace(' ', '', $ruble));
                    logger('min_price: ' . $min_price);
                    logger($matchesPrice);
                    break;
                }
            }
        }
        if (count($matchesPrice['percent']) > 0) {
            foreach ($matchesPrice['percent'] as $percent) {
                if (strlen($percent) > 0) {
                    $percent = (int)$percent;
                    logger('percent: ' . $percent . ' startPrice:' . $startPrice);
                    $min_price = $startPrice / 100 * $percent;
                    logger('min_price_calc: ' . $min_price);
                    break;
                }
            }
        }
        return $min_price;
    }

    public function getPeriod($matchesStep, $test)
    {
        $step = null;
        if (count($matchesStep['step_number']) > 0) {
            foreach ($matchesStep['step_number'] as $step_number) {
                if (strlen($step_number) > 0) {
                    $step = (int)$step_number;
                    $test->period = $step;
                    break;
                }
            }
        } else if (count($matchesStep['step_words']) > 0) {
            foreach ($matchesStep['step_words'] as $step_words) {
                if (strlen($step_words) > 0) {
                    $step = $this->getNumbersFromWords($step_words);
                    $test->period = $step;
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
                logger($date . '1');
                $end = Carbon::parse($end)->addDay();
            }
        }
        return $end;
    }

    public function getPriceReduction($red, $lot_id, $test)
    {
        $priceReds = [];
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
                    $this->getPriceReductionParams($matches, $test, 0, 3, 6, $lot, 5);
                }
            } elseif (str_starts_with($red, '<table><thead><tr><td>')) {
                $pattern = '/<tr[\s\S]*?<\/tr>/';
                preg_match_all($pattern, $red, $matches);
                if (count($matches[0]) > 0) {
                    unset($matches[0][0]);
                    $this->getPriceReductionParams($matches, $test, 3, 4, 1, $lot, 2);
                }
            } elseif (str_starts_with($red, '<table><thead><tr><th>')) {
                $pattern = '/<tr[\s\S]*?<\/tr>/';
                preg_match_all($pattern, $red, $matches);
                if (count($matches[0]) > 0) {
                    unset($matches[0][0]);
                    $this->getPriceReductionParams($matches, $test, 0, 3, 5, $lot, 4);
                } elseif (str_starts_with($red, '<table><tr><td>')) {
                    $pattern = '/<tr[\s\S]*?<\/tr>/';
                    preg_match_all($pattern, $red, $matches);
                    if (count($matches[0]) > 0) {
                        $this->getPriceReductionParams($matches, $test, 0, 1, 2, $lot);
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
                                    $priceReds[] = $this->savePriceReduction($lot_id, $price, $items[0], $time_end, $prev_price);
                                }
                            }
                            $i++;
                        }
                    } catch (Exception $e) {
                    }
                }

            }
            $test->price_red_json = $priceReds;
            $test->save();
        } catch
        (Exception $e) {
            logger('e: ' . $e);
            logger($red);
        }
    }

    public function getPriceReductionParams($matches, $test, $start_time_index, $end_time_index, $price_index, $lot, $deposit_index = null)
    {
        $i = 0;
        $priceReds = [];
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

                $priceReds[] = $this->savePriceReduction($lot->id, $price, $start_time, $end_time, $prev_price, 0, $deposit);
            }
            $i++;
        }
        $test->price_red_json = $priceReds;
        $test->save();
    }

    public function savePriceReduction($lot_id, $test, $price, $start_time, $end_time, $prev_price = null, $percent = 0, $deposit = 0, $is_system = false)
    {
        if (!is_null($prev_price)) {
            $percent = ((float)$prev_price - (float)$price) / (float)$prev_price * 100;
        }
        return [
            'lot_id' => $lot_id,
            'price' => $price,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'percent' => $percent,
            'deposit' => $deposit,
            'is_system' => $is_system
        ];

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
