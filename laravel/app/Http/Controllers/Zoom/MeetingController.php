<?php

namespace App\Http\Controllers\Zoom;

use App\Models\Meeting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\MeetingRequest;
use App\Client\ZoomJwtClient;

class MeetingController extends Controller
{

    // const MEETING_TYPE_INSTANT = 1;
    // const MEETING_TYPE_SCHEDULE = 2;
    // const MEETING_TYPE_RECURRING = 3;
    // const MEETING_TYPE_FIXED_RECURRING_FIXED = 8;

    const MEETING_TYPE = 2;


    private $client;

    public function __construct(ZoomJwtClient $client) {
        $this->client = $client;
    }

    // function list(Request $request) {
    public function list() {
        $path = 'users/' . config('zoom.zoom_account_email') . '/meetings';
        $response = $this->client->zoomGet($path);
        // $response = json_decode($response, true);
        // dd($response);

        $data = json_decode($response->getBody(), true);
        // dd($data);
        $data['meetings'] = array_map(function (&$m) {
            $m['start_time'] = $this->client->toUnixTimeStamp($m['start_time'], $m['timezone']);
            $m['start_time'] = date('Y/m/d H時i分', $m['start_at']);
            return $m;
        }, $data['meetings']);

        // dd($data['meetings']);
        return [
            'success' => 'ok',
            'data' => $data,
        ];
    }

    public function index()
    {
        $meetings = Meeting::all()->sortByDesc('created_at');
        return view('meetings.index', ['meetings' => $meetings]);
    }

    public function create()
    {
        return view('meetings.create');
    }

    public function store(MeetingRequest $request, Meeting $meeting)
    {
        // ZoomAPIにミーティング作成のリクエスト
        $path = 'users/' . config('zoom.zoom_account_email') . '/meetings';
        $body = [
            'type' => self::MEETING_TYPE,
            'topic' => $request['topic'],
            'start_time' => $this->client->toZoomTimeFormat($request['start_time']),
            'agenda' => $request['agenda'],
            'timezone' => "Asia/Tokyo",
        ];

        $response = $this->client->zoomPost($path, $body);

        // ミーティング開始日時を、日本時刻に変換
        $body = json_decode($response->getBody(), true);
        // dd($body['start_time']);
            $body['start_time'] = $this->client->toUnixTimeStamp($body['start_time'], $body['timezone']);
            $body['start_time'] = date('Y/m/d　H時i分', $body['start_time']);
        // dd($body);

        // 作成したミーティング情報をDBに保存
        if($response->getStatusCode() === 201) {
            $meeting->topic = $body['topic'];
            $meeting->agenda = $body['agenda'];
            $meeting->start_time = $body['start_time'];
            $meeting->start_url = $body['start_url'];
            $meeting->join_url = $body['join_url'];
            $meeting->user_id = $request->user()->id;
            $meeting->save();
            return redirect()->route('meetings.index');
        }

        return [
            'success' => $response->getStatusCode() === 201,
            'data' => $response,
        ];
    }

    public function delete(Request $request, string $id)
    {
        $path = 'meetings/' . $id;
        $response = $this->client->zoomDelete($path);

        return [
            'success' => $response->getStatusCode() === 204,
            'data' => json_decode($response->getBody(), true),
        ];
    }

    // public function get(Request $request, string $id)
    // {
    //     $path = 'meetings/' . $id;
    //     $response = $this->client->zoomGet($path);

    //     $data = json_decode($response->body(), true);
    //     if ($response->ok()) {
    //         $data['start_at'] = $this->client->toUnixTimeStamp($data['start_time'], $data['timezone']);
    //     }

    //     return [
    //         'success' => $response->ok(),
    //         'data' => $data,
    //     ];
    // }

    // public function update(Request $request, string $id)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'topic' => 'required|string',
    //         'start_time' => 'required|date',
    //         'agenda' => 'string|nullable',
    //     ]);

    //     if ($validator->fails()) {
    //         return [
    //             'success' => false,
    //             'data' => $validator->errors(),
    //         ];
    //     }
    //     $data = $validator->validated();

    //     $path = 'meetings/' . $id;
    //     $response = $this->client->zoomPatch($path, [
    //         'topic' => $data['topic'],
    //         'type' => self::MEETING_TYPE_SCHEDULE,
    //         'start_time' => (new \DateTime($data['start_time']))->format('Y-m-d\TH:i:s'),
    //         'duration' => 30,
    //         'agenda' => $data['agenda'],
    //         'settings' => [
    //             'host_video' => false,
    //             'participant_video' => false,
    //             'waiting_room' => true,
    //         ],
    //     ]);

    //     return [
    //         'success' => $response->status() === 204,
    //         'data' => json_decode($response->body(), true),
    //     ];
    // }


}
