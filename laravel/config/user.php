<?php

return [
    'guest_user' => [
        'id'                 => env('GUEST_USER_ID'),
        'name'               => 'ゲストユーザー',
        'email'              => 'guest@example.com',
        'password'           => env('GUEST_USER_PASSWORD'),
        'profile_image_path' => 'images/profile/guest.png',
    ],

    'profile_image_path' => [
        'default' => 'images/profile/default.png',
        'boy'     => 'images/profile/character_boy.png',
        'girl'    => 'images/profile/character_girl.png',
        'sun'     => 'images/profile/sun.png',
    ],
];
