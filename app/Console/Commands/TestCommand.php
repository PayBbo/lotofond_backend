<?php

namespace App\Console\Commands;

use App\Http\Services\Parse\FilesService;
use App\Jobs\ParseArbitrManager;
use App\Jobs\ParseCompanyTradeOrganizer;
use App\Jobs\ParseDebtor;
use App\Jobs\ParseSRORegister;
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

        dispatch(new ParseSRORegister);
        return 0;
    }
}
