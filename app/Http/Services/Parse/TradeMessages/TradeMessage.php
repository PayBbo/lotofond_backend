<?php

namespace App\Http\Services\Parse\TradeMessages;

use App\Http\Services\Parse\FilesService;
use App\Models\LotFile;
use Carbon\Carbon;

abstract class TradeMessage
{
    protected $type;
    protected $messageId;
    protected $invitation;
    protected $prefix;

    public function __construct($invitation, $prefix, $type, $messageId)
    {
        $this->invitation = $invitation;
        $this->prefix = $prefix;
        $this->type = $type;
        $this->messageId = $messageId;
    }

    public function parseFile($prefix, $invitation, $auction, $lot, $tradeMessage){
        if (array_key_exists($prefix . 'Attach', $invitation)) {
            $parseFiles = new FilesService();
            $files = $parseFiles->parseFiles($invitation, $auction, $prefix);
            foreach($files as $file) {
                if ($file) {
                    if (!LotFile::where(['url' => $file, 'lot_id' => $lot->id,
                        'trade_message_id' => $tradeMessage->id, 'type' => 'file'])->exists()) {
                        LotFile::create([
                            'url' => $file,
                            'type' => 'file',
                            'lot_id' => $lot->id,
                            'trade_message_id' => $tradeMessage->id
                        ]);
                    }
                }
            }
        }
    }

    public function createNotification($lot, $date,  $param = null, $param_type = null, $value = null)
    {
        return \App\Models\TradeMessage::create([
            'lot_id' => $lot,
            'value' => $this->type,
            'number' => $this->messageId,
            'text' => $value,
            'date' => $date,
            'param' => $param,
            'param_type' => $param_type,
            'created_at'=> Carbon::now()->setTimezone('Europe/Moscow')
        ]);
    }
}
