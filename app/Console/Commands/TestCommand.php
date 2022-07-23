<?php

namespace App\Console\Commands;


use App\Models\User;
use App\Notifications\PushNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;


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
        /**
        $filename = 'Фото.pdf';
        $path = 'auction-files/auction-1/17-06-2022-04-28';
        $s_path = 'app\public\auction-files\auction-1\17-06-2022-04-28';
        $gener = new FilesService();
        $gener->getImagesFromDocOrPdf($filename, $path, $s_path);
        $gener->getImagesFromDocx($filename, $path, $s_path);
        $gener->getImagesFromZipOrRar($filename, $path, $s_path);
        **/
        $user = User::find(1);
        if(!is_null($user->device_tokens)) {
            try {
                Notification::send(null, new PushNotification('Hello', 'New Message', $user->device_tokens));
            }catch(\Exception $e){
                logger($e);
            }
        }
    }
}
