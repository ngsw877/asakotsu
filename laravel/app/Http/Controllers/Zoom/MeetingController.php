<?php

namespace App\Http\Controllers\Zoom;

use App\Client\ZoomJwtClient;
use App\Models\Meeting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\MeetingRequest;
use Carbon\CarbonImmutable;

class MeetingController extends Controller
{
    private $client;
    private CarbonImmutable $today;

    public function __construct(
        ZoomJwtClient $client
    ) {
        $this->client = $client;
        $this->today = CarbonImmutable::today();
        $this->authorizeResource(Meeting::class, 'meeting');
    }

    /**
     * 作成済みミーティング情報を一覧で取得
     */
    public function getListMeetings()
    {
        $path = 'users/' . config('zoom.zoom_account_email') . '/meetings';
        $response = $this->client->zoomGet($path);

//        dd(json_decode($response->getBody(), true));
        return $response;
    }

    /**
     * 指定したミーティング情報の取得
     * @param int $meetingId
     */
    public function getMeeting(int $meetingId)
    {
        $path = 'meetings/' . $meetingId;
        $response = $this->client->zoomGet($path);

//        dd($response);
        return $response;
    }

    /**
     * 作成済みのミーティングの、「開始日」と「ステータス」をチェックし、過去のミーティングを削除する
     * @return void
     */
    public function checkStartTimeAndStatusOfMeetings(): void
    {
        // 作成済みミーティングの情報を全件取得
        $response = $this->getListMeetings();
        $bodies = json_decode($response->getBody(), true);
        $meetings = $bodies['meetings'];

        // 作成済みミーティングの、ミーティングIDのみを取得

        foreach ($meetings as $meeting) {
            $response = $this->getMeeting($meeting['id']);
            $body = json_decode($response->getBody(), true);

            // ミーティング開始時間を取得（timezoneはAsia/Tokyo）
            $startTime = $this->client
                ->changeDateTimeForTimezone(
                    $body['start_time'],
                    $body['timezone']
                );

            // ミーティングのステータスを取得
            $meetingStatus = $body['status'];

            // 作成済みのミーティングの、「開始日」と「ステータス」をチェック
            if ($startTime < $this->today &&
                $meetingStatus === config('zoom.meeting_status.inactive')) {
                // ミーティングの「開始日」が「今日」より前で、かつ「ステータス」が「waiting」である
                // 過去のミーティングを削除する
                $meeting = new Meeting();
                $meeting = $meeting->findByMeetingId($body['id']);

                if (isset($meeting)) {
                    $this->destroy($meeting);
                } else {
                    \Log::warning('DBからミーティングIDを取得できませんでした。');
                }
            }
        }
        \Log::info('過去のミーティングがあるかをチェックするバッチ処理が正常終了しました。');
    }

    public function index(Request $request)
    {
        // ミーティングをキーワードで検索
        $freeWord = $request->input('free_word');

        $meetings = Meeting::searchByFreeWord($freeWord)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('meetings.list', ['meetings' => $meetings])->render(),
                'next' => $meetings->appends($request->only('free_word'))->nextPageUrl()
            ]);
        }

        return view('meetings.index', [
            'meetings' => $meetings,
            'freeWord' => $freeWord
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
        $changedDateTime = $this->client->changeDateTimeForTimezone($body['start_time'], $body['timezone']);
        $body['start_time'] = $changedDateTime->format('Y-m-d\TH:i');

        // 作成したミーティング情報をDBに保存
        if ($response->getStatusCode() === 201) {  // 201：ミーティング作成成功のHTTPステータスコード
            $meeting
                ->fill(
                    $body +
                        [
                            'meeting_id' => $body['id'],
                            'user_id' => $request->user()->id,
                            'ip_address' => $request->ip()
                        ]
                )
                ->save();

            toastr()->success('ミーティングを作成しました');
            return redirect()->route('meetings.index');
        }

        toastr()->error('ミーティングの作成に失敗しました');

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

            toastr()->success('ミーティングを削除しました');

            \Log::info("ミーティングID：{$id}のミーティングを削除しました。");
            return redirect()->route('meetings.index');
        }

        toastr()->error('ミーティングの削除に失敗しました');

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

             toastr()->success('ミーティングを更新しました');

             return redirect()->route('meetings.index');
         }

        toastr()->error('ミーティングの更新に失敗しました');

        // エラーページにリダイレクト
        return view('errors.meeting', ['method' => '更新']);
    }
}
