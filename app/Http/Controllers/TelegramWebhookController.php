<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\BotsManager;
use Telegram\Bot\Exceptions\TelegramSDKException;

class TelegramWebhookController extends Controller
{
    protected $botsManager;

    public function __construct(BotsManager $botsManager)
    {
        $this->botsManager = $botsManager;
    }

    public function __invoke(Request $request)
    {
        try {

            $updates = $this->botsManager->getWebhookUpdate();
            // Extract the message object from the updates
            $message = $updates->getMessage();

            // Get the text of the message sent by the user
            $text = $message->getText();

            // Get the unique chat ID where the message was sent from
            $chatId = $message->getChat()->getId();

            logger('telegram updates = '
                .json_encode(['message'=>$message, 'text' => $text, 'chat_id' => $chatId],JSON_UNESCAPED_UNICODE));
            $this->botsManager->bot()->commandsHandler(true);
            return response(null, 200);
        } catch (TelegramSDKException $e) {
            return response()->json(['message' => $e->getMessage()], 200);
        }
    }

}
