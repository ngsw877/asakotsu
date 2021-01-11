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

    public function index(Request $request)
    {
        ### ユーザー投稿の検索機能 ###
        $search = $request->input('search');

        $query = Meeting::query();

        //もしキーワードがあったら
        if ($search !== null){
            //全角スペースを半角に
            $search_split = mb_convert_kana($search,'s');

            //空白で区切る
            $search_split2 = preg_split('/[\s]+/', $search_split,-1,PREG_SPLIT_NO_EMPTY);

            //単語をループで回す
            foreach($search_split2 as $value)
            {
            $query->where('topic','like','%'.$value.'%')
            ->orWhere('agenda','like','%'.$value.'%');
            }
        };

        ### ミーティング一覧を、無限スクロールで表示 ###
        $meetings = $query->with(['user'])
        ->orderBy('created_at', 'desc')
        ->paginate(5);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('meetings.list', ['meetings' => $meetings])->render(),
                'next' => $meetings->appends($request->only('search'))->nextPageUrl()
            ]);
        }

        return view('meetings.index', [
            'meetings' => $meetings,
            'search' => $search
            ]);
    }

    public function create()
    {
        return view('meetings.create');
    }

    public function store(MeetingRequest $request, Meeting $meeting)
    {
        // 二重送信対策
        $request->session()->regenerateToken();

        // ZoomAPIへ、ミーティング作成のリクエスト
        $path = 'users/' . config('zoom.zoom_account_email') . '/meetings';
        $response = $this->client->zoomPost($path, $request->zoomParams());

        // レスポンスのミーティング開始日時を、日本時刻に変換
        $body = json_decode($response->getBody(), true);
        $body['start_time'] = $this->client->toUnixTimeStamp($body['start_time'], $body['timezone']);
        $body['start_time'] = date('Y-m-d\TH:i:s', $body['start_time']);

        // 作成したミーティング情報をDBに保存
        if ($response->getStatusCode() === 201) {  // 201：ミーティング作成成功のHTTPステータスコード
            $meeting
                ->fill($body + [ 'meeting_id' => $body['id'], 'user_id' => $request->user()->id ])
                ->save();

            session()->flash('msg_success', 'ミーティングを作成しました');
            return redirect()->route('meetings.index');
        }

        // エラーページにリダイレクト
        return view('errors.meeting', ['method' => '作成']);
    }

    public function destroy(Meeting $meeting)
    {
        // ZoomAPIにミーティング削除のリクエスト
        $id = $meeting->meeting_id;
        $path = 'meetings/' . $id;
        $response = $this->client->zoomDelete($path);

        // DBからもミーティングを削除
        if ($response->getStatusCode() === 204) {  // 204：ミーティング削除成功のHTTPステータスコード
            $meeting->delete();

            session()->flash('msg_success', 'ミーティングを削除しました');

            return redirect()->route('meetings.index');
        }

        // エラーページにリダイレクト
        return view('errors.meeting', ['method' => '削除']);
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
        $response = $this->client->zoomPatch($path, $request->zoomParams());

         // DBに更新後のミーティングを保存
         if ($response->getStatusCode() === 204) {  // 204：ミーティング更新成功のHTTPステータスコード
            $meeting->fill($request->validated())->save();

            session()->flash('msg_success', 'ミーティングを編集しました');

            return redirect()->route('meetings.index');
        }

        // エラーページにリダイレクト
        return view('errors.meeting', ['method' => '更新']);
    }

}
