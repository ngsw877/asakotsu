<?php

return [
    'zoom_api_url' => env('ZOOM_API_URL'),
    'zoom_api_key' => env('ZOOM_API_KEY'),
    'zoom_api_secret' => env('ZOOM_API_SECRET'),
    'zoom_account_email' => env('ZOOM_ACCOUNT_EMAIL'),
    'meeting_status' => [
        'active' => 'started',
        'inactive' => 'waiting'
    ],
    'meeting_type' => [
        'instant_meeting' => 1,
        'scheduled_meeting' => 2,
        'recurring_meeting_with_no_fixed_time' => 3,
        'recurring_meeting_with_fixed_time' => 8
    ]
];
