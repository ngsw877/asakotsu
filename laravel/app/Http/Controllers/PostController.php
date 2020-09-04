<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;

class PostController extends Controller
{
    public function index()
    {
        $tag_id = "laravel";

        $url = "https://qiita.com/api/v2/tags/" . $tag_id . "/items?page=1&per_page=20";
        $method = "GET";

        //接続
        $client = new Client();

        $response = $client->request($method, $url);

        $posts = $response->getBody();
        $posts = json_decode($posts, true);

        return view('post', ['posts' => $posts]);
    }
}
