<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class FonnteService
{
    protected ?string $token;
    protected ?string $url;
    protected bool $fakeMode;

    public function __construct()
    {
        $this->token    = config('services.fonnte.token');
        $this->url      = config('services.fonnte.url');
        $this->fakeMode = (bool) config('services.fonnte.fake_mode', false);

        if (!$this->fakeMode && empty($this->token)) {
            throw new RuntimeException('FONNTE_TOKEN belum diset di file .env');
        }
    }

    public function send(string $phone, string $message): array
    {
        if ($this->fakeMode) {
            return $this->fakeSend($phone, $message);
        }

        $response = Http::withHeaders([
            'Authorization' => $this->token,
        ])->post($this->url, [
            'target'  => $phone,
            'message' => $message,
        ]);

        $result = $response->json();

        Log::info('Fonnte Response', [
            'phone'  => $phone,
            'status' => $response->status(),
            'result' => $result,
        ]);

        return $result;
    }

    protected function fakeSend(string $phone, string $message): array
    {
        $result = [
            'status'    => true,
            'detail'    => 'FAKE MODE: pesan tidak benar-benar dikirim',
            'target'    => [$phone],
            'requestid' => rand(100000000, 999999999),
        ];

        Log::info('Fonnte FAKE Response (tidak benar-benar dikirim)', [
            'phone'   => $phone,
            'message' => $message,
            'result'  => $result,
        ]);

        return $result;
    }
}
