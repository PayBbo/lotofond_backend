<?php

namespace App\Console\Commands;

use App\Http\Services\Parse\FilesService;
use App\Http\Services\Parse\TradeService;
use App\Jobs\ParseArbitrManager;
use App\Jobs\ParseCompanyTradeOrganizer;
use App\Jobs\ParseDebtor;
use App\Jobs\ParseSRORegister;
use App\Jobs\ParseTrades;
use Illuminate\Console\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:test';

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

      //  $filename = 'Архив-извещения-о-проведении-торгов-№22935.zip';
        //$filename = 'Фото-объекта.pdf';
       // $filename = 'Фото.docx';
         //$filename = 'Архив.rar';
      //  $path = 'auction-files/auction-940/17-06-2022-04-28';
      //  $s_path = 'app\public\auction-files\auction-940\17-06-2022-04-28';
      //  $gener = new FilesService();
       // $gener->getZipFiles($filename, $path, $s_path, true);
        // $gener->getRarFiles($filename, $path, $s_path, true);
        //$gener->getImagesFromPDF($filename, $path, $s_path);
       // $gener->getImagesFromDoc($filename, $path, $s_path);

       dispatch(new ParseTrades);
       // logger($this->is_image(\storage_path("app\\public\\фото")));
    }

    public function is_image($path)
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $image_type = finfo_file($finfo, $path);
        if(in_array($image_type , array("image/jpeg" ,"image/png" , "image/bmp"))) { return true; }
        return false;
    }
}
