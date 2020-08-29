<?php

namespace App\Http\Controllers\Zoom;

use App\Http\Controllers\Controller;
use App\Traits\ZoomJWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MeetingController extends Controller
{
    use ZoomJWT;

    // const MEETING_TYPE_INSTANT = 1;
    // const MEETING_TYPE_SCHEDULE = 2;
    // const MEETING_TYPE_RECURRING = 3;
    // const MEETING_TYPE_FIXED_RECURRING_FIXED = 8;

    function list(Request $request) {
        $path = 'users/' . env('ZOOM_ACCOUNT_EMAIL', '') . '/meetings';
        $response = $this->zoomGet($path);

        $data = json_decode($response->getBody(), true);
        $data['meetings'] = array_map(function (&$m) {
            $m['start_at'] = $this->toUnixTimeStamp($m['start_time'], $m['timezone']);
            return $m;
        }, $data['meetings']);

        return [
            'success' => 'ok',
            'data' => $data,
        ];
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'topic' => 'required|string',
            'start_time' => 'required|date',
            'type' => 'required|integer',
            'agenda' => 'string|nullable',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'data' => $validator->errors(),
            ];
        }
        $data = $validator->validated();

        $path = 'users/' . env('ZOOM_ACCOUNT_EMAIL', '') . '/meetings';
        $body = [
            'topic' => $data['topic'],
            'type' => $data['type'],
            'start_time' => $this->toZoomTimeFormat($data['start_time']),
            'timezone' => "Asia/Tokyo",
        ];
        $response = $this->zoomPost($path, $body);

        dd($response);
        return [
            'success' => $response->status() === 201,
            'data' => json_decode($response, true),
        ];
    }

    // public function get(Request $request, string $id)
    // {
    //     $path = 'meetings/' . $id;
    //     $response = $this->zoomGet($path);

    //     $data = json_decode($response->body(), true);
    //     if ($response->ok()) {
    //         $data['start_at'] = $this->toUnixTimeStamp($data['start_time'], $data['timezone']);
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
    //     $response = $this->zoomPatch($path, [
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

    // public function delete(Request $request, string $id)
    // {
    //     $path = 'meetings/' . $id;
    //     $response = $this->zoomDelete($path);

    //     return [
    //         'success' => $response->status() === 204,
    //         'data' => json_decode($response->body(), true),
    //     ];
    // }
}
