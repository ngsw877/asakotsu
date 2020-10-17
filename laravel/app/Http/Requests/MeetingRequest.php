<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Client\ZoomJwtClient;

class MeetingRequest extends FormRequest
{

    const MEETING_TYPE_SCHEDULE = 2;

    private $client;

    public function __construct(ZoomJwtClient $client) {
        $this->client = $client;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'topic' => 'required|string|max:20',
            'start_time' => 'required|date|after_or_equal:now',
            'agenda' => 'string|max:20|nullable',
        ];
    }

    public function attributes()
    {
        return [
            'topic' => 'ミーティング名',
            'agenda' => 'テーマ',
            'start_time' => '開始日時',
            'now' => '現在',
        ];
    }

    public function zoomParams()
    {
        $validated = parent::validated();
        $validated['type'] = self::MEETING_TYPE_SCHEDULE;
        $validated['timezone'] = config('app.timezone');
        $validated['start_time'] = $this->client->toZoomTimeFormat($validated['start_time']);
        return $validated;
    }

}
