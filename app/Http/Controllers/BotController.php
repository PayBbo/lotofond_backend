<?php

namespace App\Http\Controllers;

use App\Models\UserBotFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BotController extends Controller
{
    // Method to handle incoming webhook requests from Telegram
    public function webhook(Request $request)
    {
        // Get the latest update sent by Telegram via the webhook
        $updates = $this->botsManager->getWebhookUpdates();

        // Extract the message object from the updates
        $message = $updates->getMessage();

        // Get the text of the message sent by the user
        $text = $message->getText();

        // Get the unique chat ID where the message was sent from
        $chatId = $message->getChat()->getId();

        return response()->json(['message'=>$message, 'text' => $text, 'chat_id' => $chatId], 200);
    }

    public function saveFilters()
    {
        try {
            $validator = Validator::make(request()->all(), [
                'filters' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => $validator->messages()], 500);
            }

            $userBotFilter = UserBotFilter::updateOrCreate(
                [
                    'user_id' => Auth::id()
                ],
                [
                    'filters' => request()->get('filters', [])
                ]
            );

            return response()->json(['message'=> 'Фильтр успешно сохранен', 'filter' => $userBotFilter], 200);
        }
        catch (\Exception $e) {
            return response()->json(['message'=> $e->getMessage()], 500);
        }
    }
}
