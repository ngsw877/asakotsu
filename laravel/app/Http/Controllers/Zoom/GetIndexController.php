<?php

namespace App\Http\Controllers\Zoom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GetIndexController extends Controller
{
    // use ZoomJWT;

    // public function getIndex(Request $request){
    public function index()
    {
        $list = app()->make('App\Http\Controllers\Zoom\MeetingController');
        $response =   $list->list();
        $meetings = $response['data']['meetings'];

        foreach($meetings as $meeting) {
            $data = [
                'topic' => $meeting['topic'],
            ];
        }
        dd($data);

        // ミーティング一覧情報の中から、必要な情報のみを抽出してveiwに渡す処理を記述する

    }

    public function createResponseShow()
    {
        $crs = app()->make('App\Http\Controllers\Zoom\MeetingController');
        // ミーティングを新規作成し、作成したミーティング情報から必要な情報を抽出してviewに渡す処理を記述する
    }
}
