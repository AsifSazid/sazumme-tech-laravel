<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SmsNetService {
    public function sendSms($to, $message) {
        $response = Http::get(env('SMS_NET_API_URL'), [
            'api_key' => env('SMS_NET_API_KEY'),
            'type' => 'text',
            'number' => $to,
            'senderid' => env('SMS_NET_SENDER_ID'),
            'message' => $message
        ]);

        return $response->json();
    }
}
