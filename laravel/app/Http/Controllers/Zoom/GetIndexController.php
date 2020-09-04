<?php

namespace App\Http\Controllers\Zoom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GetIndexController extends Controller
{
    // use ZoomJWT;

    // public function getIndex(Request $request){
    public function index(){
        $list = app()->make('App\Http\Controllers\Zoom\MeetingController');
        $response =   $list->list();
        $data = [
            'topic' => $response['meeting']
        ];
        dd($data['topic']);
        $data = json_decode($data);
        view('test', $data['start_time']);

    }
}
