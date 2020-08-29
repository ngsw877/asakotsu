<?php

namespace App\Traits;

use GuzzleHttp\Client;

trait ZoomJWT
{
    private function generateZoomToken()
    {
        $key = env('ZOOM_API_KEY', '');
        $secret = env('ZOOM_API_SECRET', '');
        $payload = [
            'iss' => $key,
            'exp' => strtotime('+1 minute'),
        ];
        return \Firebase\JWT\JWT::encode($payload, $secret, 'HS256');
    }

    private function getUsers()
    {
        $jwt = $this->generateZoomToken();
        $client = new \GuzzleHttp\Client([
            'base_uri' => env('ZOOM_API_URL', ''),
        ]);
        $res = $client->request('GET', 'users',
            [
                'headers' => [
                    'authorization' => 'Bearer ' . $jwt,
                ],
            ]);

        $response_body = (string) $res->getBody();
        return $response_body;
    }

    private function zoomRequest(string $method, string $path, array $query, array $body)
    {
        $jwt = $this->generateZoomToken();
        $client = new \GuzzleHttp\Client([
            'base_uri' => env('ZOOM_API_URL', ''),
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

    // public function zoomPatch(string $path, array $body = [])
    // {
    //     return $this->zoomRequest('PATCH', $path, $query = [], $body);
    // }

    // public function zoomDelete(string $path, array $body = [])
    // {
    //     return $this->zoomRequest('DELETE', $path, $query = [], $body);
    // }

    public function toZoomTimeFormat(string $dateTime)
    {
        try {
            $date = new \DateTime($dateTime);
            return $date->format('Y-m-d\TH:i:s');
        } catch (\Exception $e) {
            Log::error('ZoomJWT->toZoomTimeFormat : ' . $e->getMessage());
            return '';
        }
    }

    public function toUnixTimeStamp(string $dateTime, string $timezone)
    {
        try {
            $date = new \DateTime($dateTime, new \DateTimeZone($timezone));
            return $date->getTimestamp();
        } catch (\Exception $e) {
            Log::error('ZoomJWT->toUnixTimeStamp : ' . $e->getMessage());
            return '';
        }
    }

}
