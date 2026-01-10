<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class TelegramHelper
{
    public static function sendMessage($message)
    {
        $token = '7978988189:AAGtVe6xnpqPVW90sRfi8M6Wmu7SaHQZdeU';
        $chat_id = '5469447675';

        $url = "https://api.telegram.org/bot{$token}/sendMessage";

        $response = Http::get($url, [
            'chat_id' => $chat_id,
            'text' => $message,
        ]);

        return $response->successful();
    }
}
