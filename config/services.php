<?php

return [

    'vk' => [
        'token' => env('VK_TOKEN'),
    ],

    'rk' => [
        'host' => env('RK_HOST'),
        'port' => env('RK_PORT'),
        'user' => env('RK_USERNAME'),
        'pass' => env('RK_PASSWORD'),
    ],

    'sms' => [
        'login' => env('SMS_LOGIN'),
        'password' => env('SMS_PASSWORD'),
    ],

];
