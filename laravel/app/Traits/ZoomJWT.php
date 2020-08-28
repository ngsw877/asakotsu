<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use \GuzzleHttp\Client;
use \Firebase\JWT\JWT;

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
        return JWT::encode($payload, $secret, 'HS256');
    }

    private function retrieveZoomUrl()
    {
        return env('ZOOM_API_URL', '');
    }

    private function zoomRequest()
    {
        $jwt = $this->generateZoomToken(); // トークンを取得
        $client = new Client(['base_uri' => 'https://api.zoom.us/v2/']); //Clientクラスをインスタンス化、コンストラクタにURLを設定
        $res = $client->request('GET', '/', [   // GETメソッドを使用して、ZoomAPIに次の３つを送信する
            'authorization' => 'Bearer ' . $jwt,  // ①パス「/」、②Zoom認証情報、③json形式にするという設定情報
            'content-type' => 'application/json',
        ]);
       return $res;  // GETリクエストに対してのレスポンス情報をreturnする
    }


    public function sendPost()
    // public function sendPost(string $path, array $query = [])
    {
        $url = $this->retrieveZoomUrl();
        $request = $this->zoomRequest();
        $jwtToken = env('ZOOM_JWT_TOKEN', '');
        $email = env('', '');

        $path = 'users/${email}/meetings';

        // dd($request);
        $client = new Client(['base_uri' => $url]);
        $options = [
            'headers'=> [
                'authorization' => 'Bearer' . $jwtToken
            ],
            'json' => [
                "topic"=> "Weekly Meeting",
                "type"=> "2",
                "start_time"=> "2020-08-31T18:30:00",
                "timezone"=> "Asia/Tokyo",
                "settings"=> [
                    "use_pmi"=> "false",
                ],
            ],
            'http_errors' => false,
        ];
        $response = $client->request('POST', $path, $options);
        // $response = $client->request('POST', $path, $options);

        dd($response);
        return $response;
    }

    public function sendGet(string $path, array $query = [])
    {
        $url = $this->retrieveZoomUrl();
        $request = $this->zoomRequest();

        dd($request); // ddを追加

        $client = new Client(['base_uri' => $url]);
        // dd($client);
        $options = ['http_errors' => false];
        $response = $client->request('GET', $path, $query);  

        // dd($response);
        return $response;

    }
    // status code
    // $statusCode = $response->getStatusCode()->getContents();
    // response body
    // $responseBody = $response->getBody()->getContents();
    // return $this->response($responseBody);

        public function zoomGet(string $path, array $query = [])
    {
        $url = $this->retrieveZoomUrl(); // retrieveZoomUrl()メソッドで、環境変数に設定したZoomURLを取得
        $request = $this->zoomRequest(); // zoomRequest()で、ZoomAPIにGETリクエストをしてレスポンスを得る
        return $request->get($url . $path, $query); // 会議リスト表示APIにリクエスト
    }





    public function sendGet22()
    {
        $client = new Client(['base_uri' => $this->retrieveZoomUrl()]);
        $path = '/users/{userId}/meetings';
        $options = ['http_errors' => false];
        $response = $client->request('GET', $path, $options);

        // status code
        $statusCode = $response->getStatusCode()->getContents();
        // response body
        $responseBody = $response->getBody()->getContents();

        return $client->response($responseBody);
    }


    // public function zoomGet(string $path, array $query = [])
    // {
    //     $url = $this->retrieveZoomUrl();
    //     $request = $this->zoomRequest();
    //     $responseBody = $request->getBody()->getContents();
    //     return $request->response($responseBody);
    // }

    // public function zoomGet(string $path, array $query = [])
    // {
    //     $url = $this->retrieveZoomUrl();
    //     $request = $this->zoomRequest();
    //     return $request->get($url . $path, $query);
    // }

    public function zoomPost(string $path, array $body = [])
    {
        $url = $this->retrieveZoomUrl();
        $request = $this->zoomRequest();
        return $request->post($url . $path, $body);
    }

    public function zoomPatch(string $path, array $body = [])
    {
        $url = $this->retrieveZoomUrl();
        $request = $this->zoomRequest();
        return $request->patch($url . $path, $body);
    }

    public function zoomDelete(string $path, array $body = [])
    {
        $url = $this->retrieveZoomUrl();
        $request = $this->zoomRequest();
        return $request->delete($url . $path, $body);
    }

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
