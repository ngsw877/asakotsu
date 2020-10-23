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
    const MEETING_TYPE_SCHEDULE = 2;
    // const MEETING_TYPE_RECURRING = 3;
    // const MEETING_TYPE_FIXED_RECURRING_FIXED = 8;

    private $client;

    public function __construct(ZoomJwtClient $client) {
        $this->client = $client;

        $this->authorizeResource(Meeting::class, 'meeting');
    }

    // function list(Request $request) {
    public function list() {
        $path = 'users/' . config('zoom.zoom_account_email') . '/meetings';
        $response = $this->client->zoomGet($path);
        // $response = json_decode($response, true);
        // dd($response);

        $data = json_decode($response->getBody(), true);
        dd($data);
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
        // ZoomAPIへ、ミーティング作成のリクエスト
        $path = 'users/' . config('zoom.zoom_account_email') . '/meetings';
        $response = $this->client->zoomPost($path, $request->zoomParams());

        // レスポンスのミーティング開始日時を、日本時刻に変換
        $body = json_decode($response->getBody(), true);
        $body['start_time'] = $this->client->toUnixTimeStamp($body['start_time'], $body['timezone']);
        $body['start_time'] = date('Y-m-d\TH:i:s', $body['start_time']);
        // dd($body['start_time']);
        // dd($body);

        // 作成したミーティング情報をDBに保存
        if($response->getStatusCode() === 201) {  // 201：ミーティング作成成功のHTTPステータスコード
            $meeting
                ->fill($body + [ 'meeting_id' => $body['id'], 'user_id' => $request->user()->id ])
                ->save();

            session()->flash('flash_message', 'ミーティングを作成しました');
            return redirect()->route('meetings.index');
        }
    }

    public function destroy(Meeting $meeting)
    {
        // ZoomAPIにミーティング削除のリクエスト
        $id = $meeting->meeting_id;
        $path = 'meetings/' . $id;
        $response = $this->client->zoomDelete($path);

        // DBからもミーティングを削除
        if($response->getStatusCode() === 204) {  // 204：ミーティング削除成功のHTTPステータスコード
            $meeting->delete();

            session()->flash('flash_message', 'ミーティングを削除しました');

            return redirect()->route('meetings.index');
        }
    }

    public function edit(Meeting $meeting)
    {
        return view('meetings.edit', ['meeting' => $meeting]);
    }

        public function update(MeetingRequest $request, Meeting $meeting)
    {
        // ZoomAPIにミーティング更新のリクエスト
        $id = $meeting->meeting_id;
        $path = 'meetings/' . $id;
        // dd($id);
        $response = $this->client->zoomPatch($path, $request->zoomParams());
        // dd($response);

         // DBに更新後のミーティングを保存
         if($response->getStatusCode() === 204) {  // 204：ミーティング更新成功のHTTPステータスコード
            $meeting->fill($request->validated())->save();

            session()->flash('flash_message', 'ミーティングを編集しました');

            return redirect()->route('meetings.index');
        }
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




}
