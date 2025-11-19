<?php

namespace App\Services;

class TranslationService
{

    public function translateText(array $data): string
    {
        $text = urlencode($data['text']);
        $to = $data['to'];
        $from = $data['from'] ?? 'auto';
        $translateUrl = env('GOOGLE_TRANSLATE_URL');
        $url = str_replace(
            ['{from}', '{to}', '{text}'],
            [$from, $to, $text],
            $translateUrl
        );
        try {
            $response = file_get_contents($url);
            $decoded = json_decode($response, true);
            return $decoded[0][0][0] ?? 'Translation failed';
        } catch (\Exception $e) {
            return 'Translation failed';
        }
    }
}
