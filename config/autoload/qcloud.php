<?php
declare(strict_types=1);
return [
    'app_id' => env('QCLOUD_APP_ID'),
    'secret_id' => env('QCLOUD_SECRET_ID'),
    'secret_key' => env('QCLOUD_SECRET_KEY'),
    'cos' => [
        'region' => env('COS_REGION'),
        'bucket' => env('COS_BUCKET'),
        'prefix' => env('COS_PREFIX', '')
    ],
    'api' => [
        'url' => env('QCLOUD_API'),
        'appkey' => env('QCLOUD_API_APPKEY'),
        'appsecret' => env('QCLOUD_API_APP_SECRET')
    ]
];