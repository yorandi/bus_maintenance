<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class WhatsAppChannel
{
    public function send($notifiable, Notification $notification)
    {
        $phone = $notifiable->routeNotificationFor('whatsapp', $notification);
        if (empty($phone)) {
            return;
        }

        $message = $notification->toWhatsApp($notifiable);
        if (empty($message)) {
            return;
        }

        $url = config('services.whatsapp.url');
        $enabled = config('services.whatsapp.enabled', true);
        $testMode = config('services.whatsapp.test_mode', false);

        if (! $enabled) {
            Log::info('WhatsAppChannel disabled in configuration, skipping message');
            return;
        }

        if (empty($url) && ! $testMode) {
            Log::warning('WhatsAppChannel skipped because services.whatsapp.url is empty');
            return;
        }

        $payload = [
            'phone' => $phone,
            'message' => $message,
            'sender' => config('services.whatsapp.sender'),
        ];

        if ($testMode) {
            Log::info('WhatsAppChannel test mode, message not sent', [
                'phone' => $phone,
                'payload' => $payload,
            ]);
            return;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.config('services.whatsapp.key'),
                'Accept' => 'application/json',
            ])->post($url, array_filter($payload));

            if (! $response->successful()) {
                Log::error('WhatsAppChannel failed', [
                    'phone' => $phone,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
            }
        } catch (Throwable $exception) {
            Log::error('WhatsAppChannel exception', [
                'phone' => $phone,
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
