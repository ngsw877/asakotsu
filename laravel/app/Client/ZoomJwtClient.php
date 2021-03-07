<?php

namespace App\Client;

use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Carbon\CarbonImmutable;

class ZoomJwtClient
{
    private function generateZoomToken()
    {
        $key = config('zoom.zoom_api_key');
        $secret = config('zoom.zoom_api_secret');
        $payload = [
            'iss' => $key,
            'exp' => strtotime('+1 minute'),
        ];
        return \Firebase\JWT\JWT::encode($payload, $secret, 'HS256');
    }


    private function zoomRequest(string $method, string $path, array $query, array $body)
    {
        $jwt = $this->generateZoomToken();
        $client = new Client([
            'base_uri' => config('zoom.zoom_api_url'),
        ]);

        $response = $client->request($method, $path,
            [
                'headers' => [
                    'authorization' => 'Bearer ' . $jwt,
                    'content-type' => 'application/json',
                ],
                'query' => json_encode($query),
                'body' => json_encode($body),
            ], );
        return $response;
    }

    public function zoomGet(string $path, array $query = [])
    {
        return $this->zoomRequest('GET', $path, $query, $body = []);
    }

    public function zoomPost(string $path, array $body = [])
    {
        return $this->zoomRequest('POST', $path, $query = [], $body);
    }

    public function zoomPatch(string $path, array $body = [])
    {
        return $this->zoomRequest('PATCH', $path, $query = [], $body);
    }

    public function zoomDelete(string $path, array $body = [])
    {
        return $this->zoomRequest('DELETE', $path, $query = [], $body);
    }

    /**
     * Zoomミーティングへのリクエスト用のフォーマットに、日付時刻を変換
     * →　YYYY-MM-DD T HH:mm:ss
     * @param CarbonImmutable $dateTime
     * @return string
     */
    public function toZoomTimeFormat(string $dateTime): string
    {
        $dateTime = new CarbonImmutable($dateTime);
        // 秒まで指定しないと正しくリクエストが送られない
        return $dateTime->format('Y-m-d\TH:i:s');
    }

    /**
     * timezoneを元に、日付時刻を変換する
     * @param string $dateTime
     * @param string $timezone
     * @return CarbonImmutable
     */
    public function changeDateTimeForTimezone(string $dateTime, string $timezone): CarbonImmutable
    {
            $dateTime = new CarbonImmutable($dateTime);
            return  $dateTime->setTimezone($timezone);
    }


}
