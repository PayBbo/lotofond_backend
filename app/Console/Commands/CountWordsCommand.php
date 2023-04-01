<?php

namespace App\Console\Commands;

use App\Models\AdditionalLotInfo;
use Illuminate\Console\Command;

class CountWordsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'count:words';

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
        $texts = AdditionalLotInfo::get();
        $result = [];
        foreach ($texts as $addition) {
            $text = $addition->message;

            //remove html tags
            $text = str_replace('</p>', ' </p>', $text);
            $text = str_replace('<br>', ' ', $text);
            $text = str_replace("&nbsp;", " ", $text);
            $text = preg_replace("/<([^>]*(<|$))/", "&lt;$1 ", $text);
            $text = strip_tags($text);
            $text = str_replace(chr(194), " ", $text);
            $text = str_replace(chr(160), " ", $text);
            $text = preg_replace(array('/\s{2,}/', '/[\r\t\n]/', '/\r/', '/\t/', '/\n/'), ' ', $text);
            $text = str_replace("&lt;", "", str_replace("&gt;", "", $text));
            $text = iconv('utf-8//IGNORE', 'windows-1251//IGNORE', $text);
            $text = iconv('windows-1251//IGNORE', 'utf-8//IGNORE', $text);
            $addition->message = $text;
            $addition->save();

            //end remove html tags
             $parca = explode(" ", $text);
             foreach ($parca as $item) {
                 if($item != "") {
                     if (!array_key_exists($item, $result)) {
                         $result[$item] = substr_count($text, $item);
                     } else {
                         $result[$item] += substr_count($text, $item);
                     }
                 }
             }
        }
        return 0;
    }
}
